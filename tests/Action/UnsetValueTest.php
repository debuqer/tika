<?php


namespace Debuqer\Tika\Tests\Action;


use Debuqer\Tika\DataStructure\ConfigContainer;
use Debuqer\Tika\Exceptions\InvalidActionConfiguration;
use Debuqer\Tika\Tests\Utils\ActionUtility;
use Debuqer\Tika\Tests\Utils\FormUtility;
use PHPUnit\Framework\TestCase;

class UnsetValueTest extends TestCase
{
    public function test_unset_value_action()
    {
        $configContainer = new ConfigContainer([
            'instance' => [
                'text:fname' => [
                    'value' => 'john'
                ],
                'text:lname' => [],
            ]
        ]);
        $form = FormUtility::createForm($configContainer);
        $action = ActionUtility::create('unset-value:action',
            [
                'event' => 'form.load',
                'item' => 'instance.text:fname',
            ]
        );
        $action->run($form);
        $this->assertNull($form->get('instance.text:fname.value'));
    }

}