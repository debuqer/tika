<?php
namespace Debuqer\TikaFormBuilder\Tests\Utils;

use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\TikaFormBuilder\Tests\TestClasses\MyCustomAction;
use Debuqer\TikaFormBuilder\Tests\TestClasses\MyCutsomProvider;

class FormUtility
{
    /**
     * @param array $model_config
     * @return \Debuqer\TikaFormBuilder\Form
     */
    public static function createForm(ConfigContainerInterface $model_config)
    {
        $model_config->merge([
            'providers' => [
                'input:my-custom' => MyCutsomProvider::class,
                'actions:my-custom' => MyCustomAction::class,
            ]
        ]);
        return new \Debuqer\TikaFormBuilder\Form($model_config);
    }
}