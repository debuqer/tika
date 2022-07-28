<?php
namespace Debuqer\TikaFormBuilder;

use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;

class Form
{
    /** @var ConfigContainerInterface  */
    protected $modelConfig;

    public function __construct(ConfigContainerInterface $modelConfig)
    {
        $this->modelConfig = $modelConfig;
    }

    /**
     * @return ConfigContainerInterface
     */
    public function getModelConfig()
    {
        return $this->modelConfig;
    }
}