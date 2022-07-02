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

        return [
            'type' => Group::class,
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'items' => $schema
        ];
    }

    /**
     * @param $item
     */
    public function append(ItemInterface $item)
    {
        $newItem = clone $item;

        $this->items[] = $newItem;
    }

    /**
     * @param ItemInterface $item
     */
    public function removeItem(ItemInterface $item)
    {
        $this->removeItemByName($item->getName());
    }

    /**
     * @param $itemName
     */
    public function removeItemByName($itemName)
    {
        $this->removeItemByCondition(function (ItemInterface $item) use ($itemName) {
            return $item->getName() != $itemName;
        });
    }

    /**
     * @param \Closure $callback
     */
    public function removeItemByCondition(\Closure $callback)
    {
        $this->items = array_filter($this->items, $callback);
    }
}