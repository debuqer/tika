<?php


namespace Debuqer\TikaFormBuilder\Instance\Inputs;


abstract class BaseInput implements InputInterface
{
    /** @var string */
    protected $name;
    /** @var array */
    protected $modelConfig;

    public function __construct($name, $modelConfig = [])
    {
        $this->name = $name;
        $this->modelConfig = $modelConfig;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getModelConfig()
    {
        return $this->modelConfig;
    }
}