<?php


namespace Debuqer\TikaFormBuilder\Tests\Event;


use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\Tests\Utils\FormUtility;

class EventTest extends \PHPUnit\Framework\TestCase
{
    public function test_form_load_event_works_in_actions()
    {
        $configContainer = new ConfigContainer([
            'instance' => [],
            'actions' => [
                'my-custom-action:on-form-load' => [
                    'event' => 'form.load'
                ],
            ],
            'meta' => [
                'custom-action-executed' => false,
            ]
        ]);
        $form = FormUtility::createForm($configContainer);

        $this->assertTrue($form->get('meta.custom-action-executed'));
    }

    public function test_input_change_event_works_in_actions()
    {
        $configContainer = new ConfigContainer([
            'instance' => [
                'my-custom-instance:fname' => []
            ],
            'actions' => [
                'my-custom-action:input-change' => [
                    'event' => 'input.change'
                ],
            ],
            'meta' => [
                'custom-action-executed' => false,
            ]
        ]);
        $form = FormUtility::createForm($configContainer);
        $form->get('instance.my-custom-instance:fname')->setProperty('value', 'hi');

        $this->assertTrue($form->get('meta.custom-action-executed'));
    }

    public function test_instance_change_event_works_in_actions()
    {
        $configContainer = new ConfigContainer([
            'instance' => [
                'my-custom-instance:fname' => []
            ],
            'actions' => [
                'my-custom-action:input-change' => [
                    'event' => 'instance.change'
                ],
            ],
            'meta' => [
                'custom-action-executed' => false,
            ]
        ]);
        $form = FormUtility::createForm($configContainer);
        $form->get('instance.my-custom-instance:fname')->setProperty('value', 'hi');

        $this->assertTrue($form->get('meta.custom-action-executed'));
    }
}