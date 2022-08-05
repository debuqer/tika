<?php


namespace Debuqer\TikaFormBuilder\Instance\Inputs;


use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\TikaFormBuilder\DataStructure\Contracts\EventSubjectInterface;
use Debuqer\TikaFormBuilder\Event\EventInterface;
use Debuqer\TikaFormBuilder\Event\InputChangeEvent;
use Debuqer\TikaFormBuilder\Form;
use Debuqer\TikaFormBuilder\Instance\Inputs\Functionalities\SetPropertyInterface;
use Debuqer\TikaFormBuilder\Instance\Instance;

abstract class BaseInput implements InputInterface, SetPropertyInterface, EventSubjectInterface
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var ConfigContainerInterface
     */
    protected $modelConfig;
    /**
     * @var Instance
     */
    protected Instance $instnce;

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
     * @param Instance $instance
     * @return $this
     */
    public function setInstance(Instance &$instance)
    {
        $this->instnce = $instance;

        return $this;
    }

    /**
     * @return Instance
     */
    public function getInstance()
    {
        return $this->instnce;
    }

    /**
     * @param $propertyName
     * @param null $fallback
     * @param bool $strict
     * @return mixed
     */
    public function get($propertyName, $fallback = null, $strict = false)
    {
        return $this->modelConfig->get($propertyName, $fallback);
    }

    public function setProperty($propertyName, $value)
    {
        $this->modelConfig->set($propertyName, $value);

        $this->trigger(new InputChangeEvent($this));
    }

    public function unsetProperty($propertyName)
    {
        $this->modelConfig->unset($propertyName);

        $this->trigger(new InputChangeEvent($this));
    }

    public function trigger(EventInterface $event)
    {
        if ( $this->getInstance() ) {
            $this->getInstance()->trigger($event);
        }
    }
}