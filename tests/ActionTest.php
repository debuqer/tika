<?php


namespace Debuqer\TikaFormBuilder\Tests;
use Debuqer\TikaFormBuilder\Action\Types\SetValue;
use Debuqer\TikaFormBuilder\Tests\Utils\ActionUtility;

class ActionTest extends BasicTestClass
{
    public function test_action_load()
    {
        $action = ActionUtility::create('set-value:action', [
            'event' => 'form.load',
            'field' => 'field_name',
        ]);

        $this->assertNotNull($action);
        $this->assertEquals('action', $action->getName());
        $this->assertEquals('form.load', $action->getEvent());
        $this->assertInstanceOf(SetValue::class, $action);
    }
}