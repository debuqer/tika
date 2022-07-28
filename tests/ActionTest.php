<?php


namespace Debuqer\TikaFormBuilder\Tests;

use Debuqer\TikaFormBuilder\Action\SetValue;
use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\Tests\Utils\FormUtility;

class ActionTest extends BasicTestClass
{
    public function test_action_load()
    {
        $action = $this->createAction('action', 'set-value', 'load', [], []);

        $this->assertNotNull($action);
        $this->assertEquals('action', $action->getName());
        $this->assertEquals('load', $action->getEvent());
        $this->assertInstanceOf(SetValue::class, $action);
    }

    public function test_set_value_action()
    {
        $configContainer = new ConfigContainer([
            'instance' => [
                'text:fname' => []
            ]
        ]);
        $form = FormUtility::createForm($configContainer);
        $action = $this->createAction('action',
            'set-value',
            'load',
            [],
            ['field' => 'text:fname', 'attribute' => 'value', 'value' => 2]
        );
        $action->run($form);

        $this->assertEquals('2',
            $form->getInstance()->getItems()->get('text:fname')->getProperty('value')
        );
    }

    protected function createAction($name, $action, $event, $conditions, $parameters)
    {
        $conditions = new ConfigContainer($conditions);
        $parameters = new ConfigContainer($parameters);

        if ( $action == 'set-value' ) {
            return new SetValue($name, $event, $conditions, $parameters);
        }
    }
}