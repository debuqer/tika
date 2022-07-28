<?php
namespace Debuqer\TikaFormBuilder\DataStructure\Contracts;

interface ConfigContainerInterface
{
    public function get($propertyName, $default);
}