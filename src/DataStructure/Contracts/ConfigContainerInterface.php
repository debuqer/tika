<?php
namespace Debuqer\TikaFormBuilder\DataStructure\Contracts;

interface ConfigContainerInterface
{
    /**
     * @param string $propertyName
     * @param array $default
     * @param bool $strict
     * @return mixed
     */
    public function get($propertyName = '', $default = [], $strict = false);
    public function set($propertyName, $value);
    public function merge($array);
    public function toArray();
}