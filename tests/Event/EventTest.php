<?php


namespace Debuqer\TikaFormBuilder\Tests\Event;


use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\Event\FormLoadEvent;
use Debuqer\TikaFormBuilder\Tests\Utils\FormUtility;

class EventTest extends \PHPUnit\Framework\TestCase
{
    public function test_event_works_in_actions()
    {
        $configContainer = new ConfigContainer([
            'instance' => [
                'my-custom-instance:fname' => [],
                'my-custom-instance:lname' => [],
            ],
            'actions' => [
                'my-custom-action:on-form-load' => [
                    'event' => 'form.load',
                    'conditions' => '!form.get("meta.custom-action-executed")'
                ],
            ],
            'meta' => [
                'custom-action-executed' => false,
            ]
        ]);
        $form = FormUtility::createForm($configContainer);

        $form->trigger(new FormLoadEvent($form));
        $this->assertTrue($form->get('meta.custom-action-executed'));
    }
}