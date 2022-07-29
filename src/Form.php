<?php
namespace Debuqer\TikaFormBuilder;

use Debuqer\TikaFormBuilder\Action\ActionManager;
use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\TikaFormBuilder\Instance\Instance;

class Form
{
    /** @var ConfigContainerInterface  */
    protected $modelConfig;
    /** @var Instance */
    protected $instance;
    /** @var ActionManager */
    protected $actions;

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
                }
            } else {
                $currentItem = $currentItem->get($block, $fallback);
            }
        }

        return $currentItem;
    }
}