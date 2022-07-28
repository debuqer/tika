<?php
namespace Debuqer\TikaFormBuilder\Tests\Utils;

use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;

class InputUtility
{
    protected static $input_types = [
        'text' => \Debuqer\TikaFormBuilder\Instance\Inputs\TextInput::class
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