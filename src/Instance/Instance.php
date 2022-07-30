<?php
namespace Debuqer\TikaFormBuilder\Instance;

use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\TikaFormBuilder\Exceptions\InvalidInputProvider;
use Debuqer\TikaFormBuilder\Exceptions\InvalidItemConfig;
use Debuqer\TikaFormBuilder\Exceptions\InvalidItemIdKey;
use Debuqer\TikaFormBuilder\Instance\Inputs\InputInterface;
use Debuqer\TikaFormBuilder\Instance\Inputs\TextInput;

class Instance
{
    /** @var ConfigContainerInterface  */
    protected ConfigContainerInterface $items;
    /** @var ConfigContainerInterface */
    protected $providers;

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
                throw new InvalidItemConfig(sprintf('Item %s config is not not valid', $itemId));
            }

            if ( $itemId == '' ) {
                throw new InvalidItemIdKey('ItemId must not be empty');
            }

            $itemIdSplited = explode(':', $itemId);
            $itemType = 'text';
            if ( count($itemIdSplited) == 2 ) {
                $itemType = $itemIdSplited[0];
                if( $itemType == '' ) {
                    $itemType = 'text';
                }
                $itemName = $itemIdSplited[1];
            } else if( count($itemIdSplited) == 1 ){
                $itemName = $itemIdSplited[0];
            } else {
                throw new InvalidItemIdKey('Item id must be satisfied by type:name or name or :name');
            }

            $itemProvider = $this->providers->get('instance:'.$itemType, null);
            if ( $itemProvider ) {
                if ( !class_implements($itemProvider, InputInterface::class) ) {
                    throw new InvalidInputProvider(sprintf('Item %s provider has not implemented InputInterface', $itemType));
                }

                $item = new $itemProvider($itemName, new ConfigContainer($itemConfig));
            } else {
                throw new InvalidItemIdKey(sprintf('Item %s type is not valid', $itemType));
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
            'instance:text' => TextInput::class,
        ]);

        foreach ($providers->toArray() as $customProviderKey => $customProviderClass) {
            if( strpos($customProviderKey, 'instance:') !== false ) {
                $this->providers->merge([$customProviderKey => $customProviderClass]);
            }
        }
    }
}