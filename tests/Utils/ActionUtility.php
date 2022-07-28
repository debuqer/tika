<?php
namespace Debuqer\TikaFormBuilder\Tests\Utils;

use Debuqer\TikaFormBuilder\Action\SetValue;
use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;

class ActionUtility
{
    protected static $action_types = [
        'set-value' => SetValue::class
    ];

    /**
     * @param $name
     * @param $action
     * @param $event
     * @param $conditions
     * @param $parameters
     * @return mixed
     */
    public static function create($name, $action, $event, $conditions, $parameters)
    {
        $conditions = new ConfigContainer($conditions);
        $parameters = new ConfigContainer($parameters);
        $className = static::$action_types[$action];

        return new $className($name, $event, $conditions, $parameters);
    }
}