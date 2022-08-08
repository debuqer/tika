<?php


namespace Debuqer\Tika\Instance\Inputs;


use Debuqer\Tika\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\Tika\DataStructure\Contracts\EventSubjectInterface;
use Debuqer\Tika\Event\EventInterface;
use Debuqer\Tika\Event\AfterInputChangeEvent;
use Debuqer\Tika\Form;
use Debuqer\Tika\Instance\Inputs\Functionalities\SetPropertyInterface;
use Debuqer\Tika\Instance\Instance;

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

    /**
     * This may be be different in defferent type of inputs
     * in text, numeric it may be value
     * in multiple select it can be values
     * in checkbox it can be checked or etc
     * @var string
     */
    protected string $value_property_name = 'value';

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

        $this->trigger(new AfterInputChangeEvent($this));
    }

    public function unsetProperty($propertyName)
    {
        $this->modelConfig->unset($propertyName);

        $this->trigger(new AfterInputChangeEvent($this));
    }

    public function setValue($value)
    {
        $this->modelConfig->set($this->getValuePropertyName(), $value);
    }

    public function trigger(EventInterface $event)
    {
        if ( $this->getInstance() ) {
            $this->getInstance()->trigger($event);
        }
    }

    public function getValuePropertyName()
    {
        return $this->value_property_name;
    }
}