<?php
namespace Debuqer\TikaFormBuilder;

use Debuqer\TikaFormBuilder\Action\ActionManager;
use Debuqer\TikaFormBuilder\Action\Types\ActionInterface;
use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\TikaFormBuilder\Event\BaseEvent;
use Debuqer\TikaFormBuilder\Event\FormLoadEvent;
use Debuqer\TikaFormBuilder\Instance\Instance;
use SplSubject;

class Form implements \SplObserver
{
    /** @var ConfigContainerInterface */
    protected $modelConfig;

    /** @var Instance */
    protected Instance $instance;

    /** @var ActionManager */
    protected ActionManager $actions;

    /** @var ConfigContainerInterface */
    protected ConfigContainerInterface $meta;

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

        $this->instance = new Instance($instance, $providers);
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

    public function trigger(BaseEvent $event)
    {
        $event->attach($this);
        $event->notify();
        $event->detach($this);
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
}