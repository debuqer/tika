<?php
namespace Debuqer\Tika;

use Debuqer\Tika\Action\ActionManager;
use Debuqer\Tika\Action\Types\ActionInterface;
use Debuqer\Tika\Action\Types\SetValue;
use Debuqer\Tika\Action\Types\UnsetValue;
use Debuqer\Tika\Action\Types\Validate;
use Debuqer\Tika\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\Tika\DataStructure\Contracts\EventSubjectInterface;
use Debuqer\Tika\DataStructure\DataContainers\ActionsDataContainer;
use Debuqer\Tika\DataStructure\DataContainers\FormDataContainer;
use Debuqer\Tika\DataStructure\DataContainers\InstanceDataContainer;
use Debuqer\Tika\DataStructure\DataContainers\ProvidersDataContainer;
use Debuqer\Tika\Event\AfterValidateEvent;
use Debuqer\Tika\Event\BeforeValidateEvent;
use Debuqer\Tika\Event\EventInterface;
use Debuqer\Tika\Event\FormChangeEvent;
use Debuqer\Tika\Event\FormLoadEvent;
use Debuqer\Tika\Event\FormSubmitEvent;
use Debuqer\Tika\Event\InstanceChangeEvent;
use Debuqer\Tika\Instance\Inputs\BaseInput;
use Debuqer\Tika\Instance\Inputs\NumericInput;
use Debuqer\Tika\Instance\Inputs\TextInput;
use Debuqer\Tika\Instance\Instance;
use Debuqer\Tika\Validation\ValidationManager;
use SplSubject;

class Form implements \SplObserver, EventSubjectInterface
{
    /** @var FormDataContainer */
    protected $model;

    /** @var Instance */
    protected Instance $instance;

    /** @var ActionManager */
    protected ActionManager $actions;

    /** @var ConfigContainerInterface */
    protected $errors;

    /** @var  array */
    protected array $observers;

    protected int $submitCounts = 0;

    public function __construct(array $model)
    {
        $this->model = new FormDataContainer($model);

        $this->buildInstance(
            $this->model->getInstances(),
            $this->model->getProviders()
        );

        $this->buildActions(
            $this->model->getActions(),
            $this->model->getProviders()
        );

        $this->trigger(new FormLoadEvent($this));
    }

    /**
     * @return FormDataContainer
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param InstanceDataContainer $instance
     * @param ProvidersDataContainer $providers
     * @throws Exceptions\InvalidInputProvider
     * @throws Exceptions\InvalidItemConfig
     * @throws Exceptions\InvalidItemIdKey
     */
    protected function buildInstance(InstanceDataContainer $instance, ProvidersDataContainer $providers)
    {
        $providers->merge([
            'instance:text' => TextInput::class,
            'instance:numeric' => NumericInput::class,
        ]);

        $this->instance = (new Instance($instance, $providers))->setForm($this);
    }

    protected function buildActions(ActionsDataContainer $actions, ProvidersDataContainer $providers)
    {
        $providers->merge([
            'actions:set-value' => SetValue::class,
            'actions:unset-value' => UnsetValue::class,
            'actions:validate' => Validate::class,
        ]);

        $this->actions = new ActionManager($actions, $providers);
    }

    /**
     * @return Instance
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * @return ActionManager
     */
    public function getActions()
    {
        return $this->actions;
    }

    public function get($key, $fallback = null)
    {
        $address = explode('.', $key);

        $currentItem = $this;
        for ($pointer = 0; $pointer < sizeof($address); $pointer++) {
            $block = $address[$pointer];

            if( $pointer == 0 ) {
                if ( $block == 'instance' ) {
                    $currentItem = $currentItem->getInstance()->getItems();
                } if ( $block == 'actions' ) {
                    $currentItem = $currentItem->getActions()->getItems();
                } if ( $block == 'meta' ) {
                    $currentItem = $this->model->getMeta();
                }
            } else {
                $currentItem = $currentItem->get($block, $fallback);
            }
        }

        return $currentItem;
    }

    public function trigger(EventInterface $event)
    {
        if ( $event instanceof InstanceChangeEvent ) {
            $this->trigger(new FormChangeEvent($event));
        }

        $event->attach($this);
        $event->notify();
        $event->detach($this);
    }

    public function validate()
    {
        $this->trigger(new BeforeValidateEvent($this));

        /**
         * @var  $itemId
         * @var BaseInput $item
         */
        $data = [];
        $rules = [];
        foreach ($this->getInstance()->getItems()->toArray() as $itemId => $item) {
            if ( $item instanceof BaseInput ) {
                $data[$itemId] = $item->get('value', null, true);

                $customValidations = $item->get('validations', [], true)->toArray();
                $inputValidations = $item->getItemValidations();
                $rules[$itemId] = array_merge($customValidations, $inputValidations);
            }
        }

        $validator = new ValidationManager();
        $validator->validate($data, $rules);

        $this->errors = $validator->getErrors();

        $this->trigger(new AfterValidateEvent($this));

        return ( count($this->errors->toArray()) == 0 );
    }

    public function update(SplSubject $event)
    {
        $actions = $this->getActions();
        /** @var ActionInterface $action */
        foreach ($actions as $action) {
            if ( $action->getEvent() === $event->getName() ) {
                if ( $action->isRunnable($this) ) {
                    $action->run($this);
                }
            }
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function isValid()
    {
        return empty($this->getErrors()->toArray());
    }

    public function submit($data)
    {
        foreach ($data as $key => $value) {
            $this->get($key)->setProperty('value', $value);
        }

        $this->submitCounts ++;
        $this->trigger(new FormSubmitEvent($this));
    }

    public function isSubmitted()
    {
        return $this->submitCounts > 0;
    }
}