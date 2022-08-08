<?php


namespace Debuqer\Tika\Tests\Action;


use Debuqer\Tika\DataStructure\ConfigContainer;
use Debuqer\Tika\Exceptions\InvalidActionConfiguration;
use Debuqer\Tika\Tests\Utils\ActionUtility;
use Debuqer\Tika\Tests\Utils\FormUtility;
use PHPUnit\Framework\TestCase;

class SetValueTest extends TestCase
{
    public function test_set_value_action()
    {
        $configContainer = new ConfigContainer([
            'instance' => [
                'text:fname' => [],
                'text:lname' => [],
            ]
        ]);
        $form = FormUtility::createForm($configContainer);
        $action = ActionUtility::create('set-value:action',
            [
                'event' => 'form.load',
                'item' => 'instance.text:fname',
                'value' => 2
            ]
        );
        $action->run($form);
        $this->assertEquals('2', $form->get('instance.text:fname.value'));

        $action = ActionUtility::create('set-value:action',
            [
                'event' => 'form.load',
                'item' => 'instance.text:lname',
                'value' => "form.get('instance.text:fname.value') * 3"
            ]
        );
        $action->run($form);
        $this->assertEquals('6', $form->get('instance.text:lname.value'));
    }

    public function test_invalid_parameters_fails()
    {
        $this->expectException(InvalidActionConfiguration::class);
        $configContainer = new ConfigContainer([
            'instance' => [
                'text:fname' => [],
                'text:lname' => [],
            ]
        ]);
        $form = FormUtility::createForm($configContainer);

        $this->expectException(InvalidActionConfiguration::class);
        $action = ActionUtility::create('set-value:action', [
            'event' => 'form.load',
        ]);

        $action->run($form);
    }
}