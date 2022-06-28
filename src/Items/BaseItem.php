<?php


namespace Debuqer\Tika\Items;


use loophp\collection\Collection;

abstract class BaseItem implements ItemInterface
{
    /**
     * @var string $name
     */
    protected $name;
    /**
     * @var string $label
     */
    protected $label;
    /**

    /**
     * @var Collection $items
     */
    protected $items;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }
}