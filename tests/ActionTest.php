<?php


namespace Debuqer\TikaFormBuilder\Tests;
use Debuqer\TikaFormBuilder\Tests\TestClasses\MyCustomAction;
use Debuqer\TikaFormBuilder\Tests\Utils\ActionUtility;

class ActionTest extends BasicTestClass
{
    public function test_action_load()
    {
        $action = ActionUtility::create('my-custom:action', [
            'event' => 'form.load',
        ]);

        $this->assertNotNull($action);
        $this->assertEquals('action', $action->getName());
        $this->assertEquals('form.load', $action->getEvent());
        $this->assertInstanceOf(MyCustomAction::class, $action);
    }
}