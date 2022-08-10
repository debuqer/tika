<?php
namespace Debuqer\Tika\Tests\Utils;

use Debuqer\Tika\DataStructure\Contracts\ConfigContainerInterface;

class InputUtility
{
    protected static $input_types = [
        'text' => \Debuqer\Tika\Instance\Inputs\TextInput::class,
        'numeric' => \Debuqer\Tika\Instance\Inputs\NumericInput::class
    ];

    /**
     * @param $type
     * @param $name
     * @param ConfigContainerInterface $model_config
     * @return mixed
     */
    public static function create($type, $name, ConfigContainerInterface $model_config)
    {
        $className = static::$input_types[$type];

        return new $className($name, $model_config);
    }
}