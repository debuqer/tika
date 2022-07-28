<?php
namespace Debuqer\TikaFormBuilder;

use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
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
    public function buildInstance(ConfigContainerInterface $instance, ConfigContainerInterface $providers)
    {
        $this->instance = new Instance($instance, $providers);
    }

    public function getIntance()
    {
        return $this->instance;
    }
}