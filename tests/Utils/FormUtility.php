<?php
namespace Debuqer\TikaFormBuilder\Tests\Utils;

class FormUtility
{
    /**
     * @param array $model_config
     * @return \Debuqer\TikaFormBuilder\Form
     */
    public static function createForm($model_config = [])
    {
        return new \Debuqer\TikaFormBuilder\Form($model_config);
    }
}