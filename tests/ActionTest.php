<?php


namespace Debuqer\TikaFormBuilder\Tests;

use Debuqer\TikaFormBuilder\Action\SetValue;
use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;

class ActionTest extends BasicTestClass
{
    public function test_action_load()
    {
        $action = $this->createAction('action', 'set-value', [], []);

        $this->assertNotNull($action);
    }

    protected function createAction($name, $event, $conditions, $parameters)
    {
        $conditions = new ConfigContainer($conditions);
        $parameters = new ConfigContainer($parameters);

        if ( $event == 'set-value' ) {
            return new SetValue($name, $event, $conditions, $parameters);
        }
    }
}