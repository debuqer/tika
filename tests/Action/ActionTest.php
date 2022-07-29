<?php


namespace Debuqer\TikaFormBuilder\Tests;
use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\Exceptions\InvalidActionConfiguration;
use Debuqer\TikaFormBuilder\Tests\TestClasses\MyCustomAction;
use Debuqer\TikaFormBuilder\Tests\Utils\ActionUtility;
use Debuqer\TikaFormBuilder\Tests\Utils\FormUtility;

class ActionTest extends BasicTestClass
{
    public function test_action_load()
    {
        $action = ActionUtility::create('my-custom-action:action', [
            'event' => 'form.load',
        ]);

        $this->assertNotNull($action);
        $this->assertEquals('action', $action->getName());
        $this->assertEquals('form.load', $action->getEvent());
        $this->assertInstanceOf(MyCustomAction::class, $action);
    }

    public function test_action_is_runnable_without_condition()
    {
        $configContainer = new ConfigContainer([
            'instance' => [
                'my-custom-instance:fname' => [],
                'my-custom-instance:lname' => [],
            ],
            'actions' => [
                'my-custom-action:on-form-load' => [
                    'event' => 'form.load',
                ],
            ],
        ]);
        $form = FormUtility::createForm($configContainer);

        $this->assertTrue($form->get('actions.my-custom-action:on-form-load')->isRunnable($form));
    }

    public function test_action_is_runnable_with_condition()
    {
        $configContainer = new ConfigContainer([
            'instance' => [
                'my-custom-instance:fname' => [
                    'value' => 'a'
                ],
            ],
            'actions' => [
                'my-custom-action:this-action' => [
                    'event' => 'form.load',
                    'conditions' => 'form.get("instance.my-custom-instance:fname.value") == "a"'
                ],
                'my-custom-action:another-action' => [
                    'event' => 'form.load',
                    'conditions' => 'form.get("instance.my-custom-instance:fname.value") == "b"'
                ],
            ],
        ]);
        $form = FormUtility::createForm($configContainer);

        $this->assertTrue($form->get('actions.my-custom-action:this-action')->isRunnable($form));
        $this->assertFalse($form->get('actions.my-custom-action:another-action')->isRunnable($form));
    }

    public function test_default_condition_is_true()
    {
        $action = ActionUtility::create('my-custom-action:action', [
            'event' => 'form.load',
        ]);

        $this->assertEquals('true', $action->getConditions());
    }

    public function test_error_on_not_having_event()
    {
        $this->expectException(InvalidActionConfiguration::class);

        $action = ActionUtility::create('my-custom-action:action', []);
    }
}