<?php
namespace Debuqer\TikaFormBuilder;

use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\TikaFormBuilder\Instance\Instance;

class Form
{
    /** @var ConfigContainerInterface  */
    protected $modelConfig;
    /** @var Instance */
    protected $instance;

    public function __construct(ConfigContainerInterface $modelConfig)
    {
        $this->modelConfig = $modelConfig;
        $this->buildInstance(
            $modelConfig->get('instance', []),
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

    public function getInstance()
    {
        return $this->instance;
    }

    public function get($key, $fallback = null)
    {
        $address = explode('.', $key);

        $currentItem = $this;
        for ($pointer = 0; $pointer < sizeof($address); $pointer++) {
            $block = $address[$pointer];

            if ( $block == 'instance' ) {
                $currentItem = $currentItem->getInstance()->getItems();
            } else {
                $currentItem = $currentItem->get($block, $fallback);
            }
        }

        return $currentItem;
    }
}