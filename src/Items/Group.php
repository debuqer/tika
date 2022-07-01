<?php


namespace Debuqer\Tika\Items;


use Debuqer\Tika\Exceptions\NotValidItemException;

class Group extends BaseItem
{
    /**
     * @var array $items
     */
    protected $items;

    public function __construct()
    {
        $this->items = [];
    }

    /**
     * @return array|mixed
     * @throws NotValidItemException
     */
    public function getSchema()
    {
        $schema = [];
        foreach ($this->items as $item) {
            if( $item instanceof ItemInterface) {
                $schema[$item->getName()] = $item->getSchema();
            } else {
                throw new NotValidItemException;
            }
        }

        return $schema;
    }

    /**
     * @param $item
     */
    public function append(ItemInterface $item)
    {
        $newItem = clone $item;

        $this->items[] = $newItem;
    }
}