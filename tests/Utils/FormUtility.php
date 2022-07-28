<?php
namespace Debuqer\TikaFormBuilder\Tests\Utils;

use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;

class FormUtility
{
    /**
     * @param array $model_config
     * @return \Debuqer\TikaFormBuilder\Form
     */
    public static function createForm(ConfigContainerInterface $model_config)
    {
        return new \Debuqer\TikaFormBuilder\Form($model_config);
    }
}