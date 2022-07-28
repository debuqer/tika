<?php
namespace Debuqer\TikaFormBuilder\DataStructure;

use Arrayy\Arrayy;
use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;

class ConfigContainer implements ConfigContainerInterface
{
    /** @var Arrayy  */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = Arrayy::create($config);
    }

    public function get($propertyName, $default)
    {
        return $this->config->get($propertyName, $default);
    }
}