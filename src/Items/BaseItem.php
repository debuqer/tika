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
     * @var string
     */
    protected $default_name = '';

    /**
     * @var string
     */
    protected $default_label = '';

    /**
     * @var Collection $items
     */
    protected $items;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name ?? $this->default_name;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label ?? $this->default_label;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }
}