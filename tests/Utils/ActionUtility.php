<?php
namespace Debuqer\Tika\Tests\Utils;

use Debuqer\Tika\Action\Types\SetItemVisibleStatus;
use Debuqer\Tika\Action\Types\SetValue;
use Debuqer\Tika\Action\Types\UnsetValue;
use Debuqer\Tika\DataStructure\ConfigContainer;
use Debuqer\Tika\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\Tika\DataStructure\DataContainers\ActionDataContainer;
use Debuqer\Tika\DataStructure\DataContainers\ActionsDataContainer;
use Debuqer\Tika\Tests\Action\SetItemVisibileStatusTest;
use Debuqer\Tika\Tests\TestClasses\MyCustomAction;
use Debuqer\Tika\Tests\TestClasses\MyCustomRuleReachAction;

class ActionUtility
{
    protected static $action_types = [
        'my-custom-action' => MyCustomAction::class,
        'my-custom-rule-reach' => MyCustomRuleReachAction::class,
        'set-value' => SetValue::class,
        'unset-value' => UnsetValue::class,
        'set-item-visible-status' => SetItemVisibleStatus::class,
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

        /** @var ActionDataContainer $configContainer */
        $configContainer = new ActionDataContainer($config);
        $configContainer->merge([]);

        return new $className($actionName, $configContainer);
    }
}