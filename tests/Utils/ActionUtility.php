<?php
namespace Debuqer\TikaFormBuilder\Tests\Utils;

use Debuqer\TikaFormBuilder\Action\Types\SetValue;
use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;

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
    public static function create($actionId, $config)
    {
        $actionType = explode(':', $actionId)[0];
        $actionName = explode(':', $actionId)[1];

        $className = static::$action_types[$actionType];

        return new $className($actionName, new ConfigContainer($config));
    }
}