<?php


namespace Debuqer\TikaFormBuilder\Instance\Inputs;


use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\TikaFormBuilder\Instance\Instance;

interface InputInterface
{
    public function __construct($name, ConfigContainerInterface $modelConfig);

    public function getName();

    /**
     * retrive any attribute of model
     * @return mixed
     */
    public function get($propertyName, $fallback = null);

    public function setInstance(Instance &$instance);

    public function getInstance();
}