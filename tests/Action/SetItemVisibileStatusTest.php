<?php


namespace Debuqer\TikaFormBuilder\Tests\Action;


use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\Exceptions\InvalidActionConfiguration;
use Debuqer\TikaFormBuilder\Tests\Utils\ActionUtility;
use Debuqer\TikaFormBuilder\Tests\Utils\FormUtility;
use PHPUnit\Framework\TestCase;

class SetItemVisibileStatusTest extends TestCase
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
        $action = ActionUtility::create('set-item-visible-status:action',
            [
                'event' => 'form.load',
                'item' => 'instance.text:fname',
                'status' => true
            ]
        );
        $action->run($form);
        $this->assertTrue($form->get('instance.text:fname.visible'));

        $action = ActionUtility::create('set-item-visible-status:action',
            [
                'event' => 'form.load',
                'item' => 'instance.text:fname',
                'status' => false
            ]
        );
        $action->run($form);

        $this->assertFalse($form->get('instance.text:fname.visible'));
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
        $action = ActionUtility::create('set-item-visible-status:action', [
            'event' => 'form.load',
        ]);

        $action->run($form);
    }
}