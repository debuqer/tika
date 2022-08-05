<?php
namespace Debuqer\TikaFormBuilder\DataStructure;

use Arrayy\Arrayy;
use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;

class ConfigContainer implements ConfigContainerInterface
{
    /**
     * @TODO
     * This class had implemented using Arrayy helper
     * it should be refactor and use php array instead
     */
    /** @var Arrayy  */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = Arrayy::create($config);
    }

    public function get($propertyName = null, $default = null, $strict = false)
    {
        $value = $this->config->get($propertyName, $default);

        if ( ! $strict ) {
            if ( $value instanceof Arrayy) {
                return new ConfigContainer($value->toArray());
            } else if ( is_array($value) ) {
                return new ConfigContainer($value);
            }
        }

        return $value;
    }

    public function set($propertyName, $value)
    {
        $this->config->set($propertyName, $value);
    }

    public function unset($propertyName)
    {
        $this->config->clear($propertyName);
    }

    public function toArray()
    {
        return $this->config->toArray();
    }

    public function merge($array)
    {
        $this->config = $this->config->mergeAppendNewIndex($array);
    }

    public function has($attribute)
    {
        return $this->config->has($attribute);
    }
}