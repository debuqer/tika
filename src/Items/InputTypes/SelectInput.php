<?php


namespace Debuqer\Tika\Items\InputTypes;


use Debuqer\Tika\Items\Attributes\OptionsAttribute;
use Debuqer\Tika\Items\Attributes\TypeAttribute;

class SelectInput extends Input
{
    protected $attributes = [
        ['provider' => OptionsAttribute::class, 'params' => []]
    ];

    protected $options = [];

    public function __construct($options = [], $attributes)
    {
        $this->options = $options;
        parent::__construct(array_merge($this->attributes, $attributes));
    }

    /**
     * @param $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}