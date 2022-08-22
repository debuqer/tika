<?php


namespace Debuqer\Tika\Action\Types;


use Debuqer\Tika\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\Tika\DataStructure\Contracts\ExpressionEvaluatorInterface;
use Debuqer\Tika\DataStructure\DataContainers\ActionDataContainer;
use Debuqer\Tika\DataStructure\DataContainers\Instance\ParametersDataContainer;
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
     * @var ActionDataContainer
     */
    protected $model;

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
                                ActionDataContainer $model
    )
    {
        $this->name = $name;
        $this->model = $model;
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
        return $this->model->getEvent();
    }

    /**
     * @return ConfigContainerInterface
     */
    public function getConditions()
    {
        return $this->model->getConditions();
    }

    /**
     * @return ParametersDataContainer
     */
    public function getParameters()
    {
        return $this->model->getParameters();
    }

    public function isRunnable(Form &$form)
    {
        return $this->expressionLanguage->evaluate($this->getConditions(), [
            'form' => $form
        ]);
    }

    public function validate()
    {
        if( !$this->getEvent() ) {
            throw new InvalidActionConfiguration(sprintf('Action %s must have valid event', $this->getName()));
        }
    }
}