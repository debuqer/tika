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
    public static function createForm(ConfigContainerInterface $model_config)
    {
        $model_config->merge([
            'providers' => [
                'instance:my-custom-instance' => MyCutsomInstance::class,
                'actions:my-custom-action' => MyCustomAction::class,
            ]
        ]);
        return new \Debuqer\Tika\Form($model_config);
    }
}