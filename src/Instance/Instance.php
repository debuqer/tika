<?php
namespace Debuqer\TikaFormBuilder\Instance;

use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\TikaFormBuilder\Instance\Inputs\TextInput;

class Instance
{
    /** @var array  */
    protected ConfigContainerInterface $items;

    public function __construct(ConfigContainerInterface $instanceConfig)
    {
        $this->items = new ConfigContainer([]);

        $items = $instanceConfig->toArray();
        /** @var ConfigContainerInterface $item */
        foreach ($items as $itemId => $itemConfig) {
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
                throw new \NotValidItemIdKey('Item id must be satisfied by type:name or name or :name');
            }

            if ( $itemType == 'text' ) {
                $item = new TextInput($itemName, new ConfigContainer($itemConfig));
            } else {
                throw new \NotValidItemIdKey(sprintf('Item %s type is not valid', $itemType));
            }

            $this->items->merge([$itemId => $item]);
        }
    }

    public function getItems()
    {
        return $this->items;
    }
}