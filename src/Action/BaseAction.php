<?php


namespace Debuqer\TikaFormBuilder\Action;


use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;

abstract class BaseAction implements ActionInterface
{
    /** @var string */
    protected $name;
    /** @var ConfigContainerInterface */
    protected $config;
    /** @var string  */
    protected $event;
    /** @var ConfigContainerInterface  */
    protected $parameters;

    public function __construct($name,
                                $event,
                                ConfigContainerInterface $conditions,
                                ConfigContainerInterface $parameters
    )
    {
        $this->name = $name;
        $this->event = $event;
        $this->conditions = $conditions;
        $this->parameters = $parameters;
    }
}