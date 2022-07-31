<?php


namespace Debuqer\TikaFormBuilder\Tests\Event;


use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\Event\FormLoadEvent;
use Debuqer\TikaFormBuilder\Tests\Utils\FormUtility;

class EventTest extends \PHPUnit\Framework\TestCase
{
    public function test_form_load_event_works_in_actions()
    {
        $configContainer = new ConfigContainer([
            'instance' => [],
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

        $this->assertTrue($form->get('meta.custom-action-executed'));
    }
}