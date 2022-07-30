<?php
namespace Debuqer\TikaFormBuilder\Tests\Utils;

use Debuqer\TikaFormBuilder\Action\Types\SetValue;
use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\TikaFormBuilder\Tests\TestClasses\MyCustomAction;
use Debuqer\TikaFormBuilder\Tests\TestClasses\MyCustomRuleReachAction;

class ActionUtility
{
    protected static $action_types = [
        'my-custom-action' => MyCustomAction::class,
        'my-custom-rule-reach' => MyCustomRuleReachAction::class,
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

        /** @var ConfigContainerInterface $configContainer */
        $configContainer = new ConfigContainer($config);
        $configContainer->merge([
            'providers' => [
                'actions:my-custom' => MyCustomAction::class,
                'actions:my-custom-rule-reach' => MyCustomRuleReachAction::class,
            ]
        ]);

        return new $className($actionName, $configContainer);
    }
}