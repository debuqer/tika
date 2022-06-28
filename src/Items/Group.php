<?php


namespace Debuqer\Tika\Items;


use loophp\collection\Collection;

class Group extends BaseItem
{
    /**
     * @var Collection $items
     */
    protected $items;

    public function getSchema()
    {
        return $this->items;
    }

    /**
     * @param mixed ...$items
     */
    public function append(...$items)
    {
        $this->items->append($items);
    }

    /**
     * @param ItemInterface $item
     * @return $this
     */
    public function addItem(ItemInterface $item)
    {
        $this->append($item);

        return $this;
    }
}