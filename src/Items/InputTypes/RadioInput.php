<?php


namespace Debuqer\Tika\Items\InputTypes;


use Debuqer\Tika\Items\Attributes\OptionsAttribute;

class RadioInput extends Input
{
    protected $attributes = [
        ['provider' => OptionsAttribute::class, 'params' => []]
    ];

    protected $options = [];

    public function __construct($attributes, $options = [])
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