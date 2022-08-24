<?php


namespace Debuqer\Tika\Action;


use Debuqer\Tika\Action\Types\ActionInterface;
use Debuqer\Tika\Action\Types\SetValue;
use Debuqer\Tika\Action\Types\UnsetValue;
use Debuqer\Tika\DataStructure\ConfigContainer;
use Debuqer\Tika\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\Tika\DataStructure\DataContainers\ActionDataContainer;
use Debuqer\Tika\DataStructure\DataContainers\ActionsDataContainer;
use Debuqer\Tika\DataStructure\DataContainers\ProvidersDataContainer;
use Debuqer\Tika\Exceptions\InvalidInputProvider;
use Debuqer\Tika\Exceptions\InvalidItemConfig;
use Debuqer\Tika\Exceptions\InvalidItemIdKey;

class ActionManager
{
    /**
     * contains all actions
     * @var ConfigContainerInterface
     */
    protected ConfigContainerInterface $items;

    /**
     * contains providers, all action type that implements ActionInterface
     * @var ConfigContainerInterface
     */
    protected ConfigContainerInterface $providers;

    /**
     * Provides a safe container for actions
     *
     * ActionManager constructor.
     * @param ActionsDataContainer $instanceConfig
     * @param ProvidersDataContainer $providers
     * @throws InvalidInputProvider
     * @throws InvalidItemConfig
     * @throws InvalidItemIdKey
     */
    public function __construct(ActionsDataContainer $instanceConfig,
                                ProvidersDataContainer $providers
    )
    {
        $this->items = new ConfigContainer([]);
        $this->setProviders($providers);

        $items = $instanceConfig->toArray();
        /** @var ConfigContainerInterface $item */
        foreach ($items as $itemId => $itemConfig) {
            if( !is_array($itemConfig) ) {
                throw new InvalidItemConfig(sprintf('Action %s config is not not valid', $itemId));
            }

            if ( $itemId == '' ) {
                throw new InvalidItemIdKey('ActionId must not be empty');
            }

            $itemIdSplited = explode(':', $itemId);
            if ( count($itemIdSplited) == 2 ) {
                $itemType = $itemIdSplited[0];
                $itemName = $itemIdSplited[1];
            } else {
                throw new InvalidItemIdKey('ActionId must be satisfied by type:name or name or :name');
            }

            /** @var ActionInterface $itemProvider */
            $itemProvider = $this->providers->get('actions:'.$itemType, null);
            if ( $itemProvider ) {
                if ( !class_implements($itemProvider, ActionInterface::class) ) {
                    throw new InvalidInputProvider(sprintf('Action %s provider has not implemented ActionInterface', $itemType));
                }

                $item = new $itemProvider($itemName, new ActionDataContainer($itemConfig));
            } else {
                throw new InvalidItemIdKey(sprintf('Action %s type is not valid', $itemType));
            }

            $this->items->merge([$itemId => $item]);
        }
    }

    /**
     *
     * @return ConfigContainerInterface
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * All action providers may register here
     *
     * @param ProvidersDataContainer $providers
     */
    protected function setProviders(ProvidersDataContainer $providers)
    {
        $this->providers = new ConfigContainer([

        ]);

        foreach ($providers->toArray() as $customProviderKey => $customProviderClass) {
            if( strpos($customProviderKey, 'actions:') !== false ) {
                $this->providers->merge([$customProviderKey => $customProviderClass]);
            }
        }
    }
}