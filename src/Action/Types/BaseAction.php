<?php


namespace Debuqer\TikaFormBuilder\Action\Types;


use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\TikaFormBuilder\DataStructure\Contracts\ExpressionEvaluatorInterface;
use Debuqer\TikaFormBuilder\DataStructure\ExpressionEvaluator;
use Debuqer\TikaFormBuilder\Exceptions\InvalidActionConfiguration;
use Debuqer\TikaFormBuilder\Form;

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
     * @param ConfigContainerInterface $config
     */
    public function __construct($name,
                                ConfigContainerInterface $config
    )
    {
        $this->name = $name;
        $this->event = $config->get('event', null);
        $this->conditions = $config->get('conditions', 'true');
        $this->parameters = $config->get();

        $this->expressionLanguage = new ExpressionEvaluator();

        $this->validate();
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

    public function isRunnable(Form &$form)
    {
        return $this->expressionLanguage->evaluate($this->conditions, [
            'form' => $form
        ]);
    }

    public function validate()
    {
        if( !$this->event ) {
            throw new InvalidActionConfiguration(sprintf('Action %s must have valid event', $this->getName()));
        }
    }
}