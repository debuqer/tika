<?php


namespace Debuqer\TikaFormBuilder\Tests;
use Debuqer\TikaFormBuilder\Action\SetValue;
use Debuqer\TikaFormBuilder\Tests\Utils\ActionUtility;

class ActionTest extends BasicTestClass
{
    public function test_action_load()
    {
        $action = ActionUtility::create('action', 'set-value', 'load', [], []);

        $this->assertNotNull($action);
        $this->assertEquals('action', $action->getName());
        $this->assertEquals('load', $action->getEvent());
        $this->assertInstanceOf(SetValue::class, $action);
    }
}