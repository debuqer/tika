<?php
namespace Debuqer\Tika;

use Debuqer\Tika\Action\ActionManager;
use Debuqer\Tika\Action\Types\ActionInterface;
use Debuqer\Tika\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\Tika\DataStructure\Contracts\EventSubjectInterface;
use Debuqer\Tika\Event\AfterValidateEvent;
use Debuqer\Tika\Event\BeforeValidateEvent;
use Debuqer\Tika\Event\EventInterface;
use Debuqer\Tika\Event\FormChangeEvent;
use Debuqer\Tika\Event\FormLoadEvent;
use Debuqer\Tika\Event\InstanceChangeEvent;
use Debuqer\Tika\Instance\Inputs\BaseInput;
use Debuqer\Tika\Instance\Instance;
use Debuqer\Tika\Validation\ValidationManager;
use SplSubject;

class Form implements \SplObserver, EventSubjectInterface
{
    /** @var ConfigContainerInterface */
    protected $modelConfig;

    /** @var Instance */
    protected Instance $instance;

    /** @var ActionManager */
    protected ActionManager $actions;

    /** @var ConfigContainerInterface */
    protected ConfigContainerInterface $meta;

    /** @var ConfigContainerInterface */
    protected $errors;

    /** @var  array */
    protected array $observers;

    public function __construct(ConfigContainerInterface $modelConfig)
    {
        $this->modelConfig = $modelConfig;
        $this->buildInstance(
            $modelConfig->get('instance', []),
            $modelConfig->get('providers', [])
        );

        $this->buildActions(
            $modelConfig->get('actions', []),
            $modelConfig->get('providers', [])
        );

        $this->meta = $modelConfig->get('meta', []);

        $this->trigger(new FormLoadEvent($this));
    }

    /**
     * @return ConfigContainerInterface
     */
    public function getModelConfig()
    {
        return $this->modelConfig;
    }

    /**
     * @param ConfigContainerInterface $instance
     */
    protected function buildInstance(ConfigContainerInterface $instance, ConfigContainerInterface $providers)
    {
        $providers->merge([
            // default providers
        ]);

        $this->instance = (new Instance($instance, $providers))->setForm($this);
    }

    protected function buildActions(ConfigContainerInterface $actions, ConfigContainerInterface $providers)
    {
        $providers->merge([
            // default providers
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

    /**
     * @return ConfigContainerInterface
     */
    public function getMeta()
    {
        return $this->meta;
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
                    $currentItem = $currentItem->getMeta();
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
                $rules[$itemId] = $item->get('validations', [], true)->toArray();
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
        $actions = $this->get('actions')->toArray();
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
}