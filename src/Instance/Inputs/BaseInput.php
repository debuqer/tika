<?php


namespace Debuqer\TikaFormBuilder\Instance\Inputs;


use Arrayy\Arrayy;

abstract class BaseInput implements InputInterface
{
    /** @var string */
    protected $name;
    /** @var Arrayy  */
    protected $modelConfig;

    public function __construct($name, $modelConfig = [])
    {
        $this->name = $name;
        $this->modelConfig = Arrayy::create($modelConfig);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Arrayy
     */
    public function getModelConfig()
    {
        return $this->modelConfig;
    }

    /**
     * @param $propertyName
     * @param null $fallback
     * @return array|Arrayy|mixed|null
     */
    public function getProperty($propertyName, $fallback = null)
    {
        return $this->modelConfig->get($propertyName, $fallback);
    }
}