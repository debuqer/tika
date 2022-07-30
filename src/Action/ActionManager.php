<?php


namespace Debuqer\TikaFormBuilder\Action;


use Debuqer\TikaFormBuilder\Action\Types\ActionInterface;
use Debuqer\TikaFormBuilder\Action\Types\SetValue;
use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\TikaFormBuilder\Exceptions\InvalidInputProvider;
use Debuqer\TikaFormBuilder\Exceptions\InvalidItemConfig;
use Debuqer\TikaFormBuilder\Exceptions\InvalidItemIdKey;

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

    public function __construct(ConfigContainerInterface $instanceConfig,
                                ConfigContainerInterface $providers
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

                $item = new $itemProvider($itemName, new ConfigContainer($itemConfig));
            } else {
                throw new InvalidItemIdKey(sprintf('Action %s type is not valid', $itemType));
            }

            $this->items->merge([$itemId => $item]);
        }
    }

    public function getItems()
    {
        return $this->items;
    }

    protected function setProviders(ConfigContainerInterface $providers)
    {
        $this->providers = new ConfigContainer([
            'actions:set-value' => SetValue::class
        ]);

        foreach ($providers->toArray() as $customProviderKey => $customProviderClass) {
            if( strpos($customProviderKey, 'actions:') !== false ) {
                $this->providers->merge([$customProviderKey => $customProviderClass]);
            }
        }
    }
}