<?php


namespace Debuqer\Tika\Instance\Inputs;


use Debuqer\Tika\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\Tika\Instance\Instance;

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

    public function getItemValidations();
}