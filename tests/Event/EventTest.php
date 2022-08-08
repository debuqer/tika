<?php


namespace Debuqer\Tika\Tests\Event;


use Debuqer\Tika\DataStructure\ConfigContainer;
use Debuqer\Tika\Tests\Utils\FormUtility;

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

    public function test_form_change_event_works_in_actions()
    {
        $configContainer = new ConfigContainer([
            'instance' => [
                'my-custom-instance:fname' => []
            ],
            'actions' => [
                'my-custom-action:input-change' => [
                    'event' => 'form.change'
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

    public function test_form_before_validation_event_works()
    {
        $configContainer = new ConfigContainer([
            'instance' => [
                'my-custom-instance:fname' => []
            ],
            'actions' => [
                'my-custom-action:input-change' => [
                    'event' => 'form.validate.before'
                ],
            ],
            'meta' => [
                'custom-action-executed' => false,
            ]
        ]);
        $form = FormUtility::createForm($configContainer);
        $form->get('instance.my-custom-instance:fname')->setProperty('value', 'hi');
        $form->validate();

        $this->assertTrue($form->get('meta.custom-action-executed'));
    }
}