<?php


namespace Debuqer\Tika\Action\Types;


use Debuqer\Tika\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\Tika\DataStructure\Contracts\ExpressionEvaluatorInterface;
use Debuqer\Tika\DataStructure\ExpressionEvaluator;
use Debuqer\Tika\Exceptions\InvalidActionConfiguration;
use Debuqer\Tika\Form;

abstract class BaseAction implements ActionInterface
{
    /**
     * Must be unique in form
     * @example set-value:actionName
     * @var string
     */
    protected $name;

    /**
     * Action configuration including event, conditions and other parameters
     * @var ConfigContainerInterface
     */
    protected $config;

    /**
     * Action event, like form.load
     * @var string
     */
    protected $event;

    /**
     * @var ConfigContainerInterface
     */
    protected $conditions;

    /**
     * @var ConfigContainerInterface
     */
    protected $parameters;

    /**
     * @var ExpressionEvaluatorInterface
     */
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