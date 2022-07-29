<?php


namespace Debuqer\TikaFormBuilder\Action;


use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\TikaFormBuilder\DataStructure\Contracts\ExpressionEvaluatorInterface;
use Debuqer\TikaFormBuilder\DataStructure\ExpressionEvaluator;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

abstract class BaseAction implements ActionInterface
{
    /** @var string */
    protected $name;
    /** @var ConfigContainerInterface */
    protected $config;
    /** @var string  */
    protected $event;
    /** @var ConfigContainerInterface  */
    protected $conditions;
    /** @var ConfigContainerInterface  */
    protected $parameters;
    /** @var ExpressionEvaluatorInterface */
    protected $expressionLanguage;

    /**
     * BaseAction constructor.
     * @param $name
     * @param $event
     * @param ConfigContainerInterface $conditions
     * @param ConfigContainerInterface $parameters
     */
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

        $this->expressionLanguage = new ExpressionEvaluator();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return ConfigContainerInterface
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @return ConfigContainerInterface
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}