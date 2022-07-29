<?php
namespace Debuqer\TikaFormBuilder\Tests\Utils;

use Debuqer\TikaFormBuilder\Action\SetValue;
use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;

class ActionUtility
{
    protected static $action_types = [
        'set-value' => SetValue::class
    ];

    /**
     * @param $name
     * @param $type
     * @param $config
     * @return mixed
     */
    public static function create($name, $type, $config)
    {
        $className = static::$action_types[$type];

        return new $className($name, new ConfigContainer($config));
    }
}