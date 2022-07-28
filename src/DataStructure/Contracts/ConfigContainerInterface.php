<?php
namespace Debuqer\TikaFormBuilder\DataStructure\Contracts;

interface ConfigContainerInterface
{
    /**
     * @param string $propertyName null for all items, dot notation
     * @param null $default default can be [] or null or etc
     * @return mixed
     */
    public function get($propertyName = '', $default = []);
    public function set($propertyName, $value);
    public function push($item);
    public function merge($array);
    public function toArray();
}