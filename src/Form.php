<?php
namespace Debuqer\TikaFormBuilder;

class Form
{
    protected $modelConfig;

    public function __construct($modelConfig = [])
    {
        $this->modelConfig = $modelConfig;
    }

    /**
     * @return array
     */
    public function getModelConfig()
    {
        return $this->modelConfig;
    }
}