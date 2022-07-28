<?php


namespace Debuqer\TikaFormBuilder\Instance\Inputs;


use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;

abstract class BaseInput implements InputInterface
{
    /** @var string */
    protected $name;
    /** @var ConfigContainerInterface  */
    protected $modelConfig;

    public function __construct($name, ConfigContainerInterface $modelConfig)
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
     * @return ConfigContainerInterface
     */
    public function getModelConfig()
    {
        return $this->modelConfig;
    }

    /**
     * @param $propertyName
     * @param null $fallback
     * @return mixed
     */
    public function getProperty($propertyName, $fallback = null)
    {
        return $this->modelConfig->get($propertyName, $fallback);
    }

    public function setProperty($propertyName, $value)
    {
        $this->modelConfig->set($propertyName, $value);
    }
}