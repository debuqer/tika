<?php


namespace Debuqer\TikaFormBuilder\Tests\Action;


use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\Exceptions\InvalidActionConfiguration;
use Debuqer\TikaFormBuilder\Tests\Utils\ActionUtility;
use Debuqer\TikaFormBuilder\Tests\Utils\FormUtility;
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
        $action = ActionUtility::create('action',
            'set-value',
            'load',
            [],
            ['field' => 'instance.text:fname.value', 'value' => 2]
        );
        $action->run($form);
        $this->assertEquals('2', $form->get('instance.text:fname.value'));

        $action = ActionUtility::create('action',
            'set-value',
            'load',
            [],
            ['field' => 'instance.text:lname.value', 'value' => "form.get('instance.text:fname.value') * 3"]
        );
        $action->run($form);
        $this->assertEquals('6', $form->get('instance.text:lname.value'));
    }

    public function test_invalid_parameters_fails()
    {
        $configContainer = new ConfigContainer([
            'instance' => [
                'text:fname' => [],
                'text:lname' => [],
            ]
        ]);
        $form = FormUtility::createForm($configContainer);

        $this->expectException(InvalidActionConfiguration::class);
        $action = ActionUtility::create('action', 'set-value', 'load', [], [

        ]);

        $action->run($form);
    }
}