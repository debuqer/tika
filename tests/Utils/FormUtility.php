<?php
namespace Debuqer\Tika\Tests\Utils;

use Debuqer\Tika\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\Tika\Tests\TestClasses\MyCustomAction;
use Debuqer\Tika\Tests\TestClasses\MyCutsomInstance;

class FormUtility
{
    /**
     * @param array $model_config
     * @return \Debuqer\Tika\Form
     */
    public static function createForm(array $model_config)
    {
        $model_config = array_merge($model_config, [
            'providers' => [
                'instance:my-custom-instance' => MyCutsomInstance::class,
                'actions:my-custom-action' => MyCustomAction::class,
            ]
        ]);
        return new \Debuqer\Tika\Form($model_config);
    }
}