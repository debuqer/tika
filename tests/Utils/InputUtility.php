<?php
namespace Debuqer\TikaFormBuilder\Tests\Utils;

class InputUtility
{
    protected static $input_types = [
        'text' => \Debuqer\TikaFormBuilder\Instance\Inputs\TextInput::class
    ];

    /**
     * @param array $model_config
     * @return \Debuqer\TikaFormBuilder\Form
     */
    public static function create($type, $name, array $model_config)
    {
        $className = static::$input_types[$type];

        return new $className($name, $model_config);
    }
}