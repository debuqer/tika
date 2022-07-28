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

    public function get($propertyName = null, $default = null)
    {
        $value = $this->config->get($propertyName, $default);

        if ( $value instanceof Arrayy) {
            return new ConfigContainer($value->toArray());
        } else if ( is_array($value) ) {
            return new ConfigContainer($value);
        }

        return $value;
    }

    public function set($propertyName, $value)
    {
        $this->config->set($propertyName, $value);
    }

    public function push($item)
    {
        $this->config->push($item);
    }

    public function toArray()
    {
        return $this->config->toArray();
    }

    public function merge($array)
    {
        $this->config = $this->config->mergeAppendNewIndex($array);
    }
}