<?php
namespace Debuqer\Tika;

use Debuqer\Tika\Items\Group;
use Debuqer\Tika\Items\ItemInterface;
use loophp\collection\Collection;

class Form
{
    /**
     * @var Collection $items
     */
    protected $items;

    /**
     * Origin group containing whole the form
     *
     * @var Group $group
     */
    protected $group;

    public function __construct()
    {
    }

    /**
     * @param ItemInterface $item
     */
    public function setItem(ItemInterface $item)
    {
        $this->items->append($item);
    }
}