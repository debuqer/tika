<?php


namespace Debuqer\Tika\Tests;


use Debuqer\Tika\Action\Types\ActionInterface;
use Debuqer\Tika\DataStructure\ConfigContainer;
use Debuqer\Tika\Instance\Inputs\InputInterface;
use Debuqer\Tika\Instance\Inputs\TextInput;
use Debuqer\Tika\Tests\TestClasses\MyCutsomInstance;
use Debuqer\Tika\Tests\Utils\FormUtility;

class FormInitialTest extends BasicTestClass
{
    protected $utils_list = ['form'];

    public function test_init_form()
    {
        $form = FormUtility::createForm(new ConfigContainer([]));

        $this->assertNotNull($form);
    }

    public function test_load_model()
    {
        $model_config = new ConfigContainer([
            'instance' => [
                'my-custom-instance:fname' => [],
                'my-custom-instance:lname' => [],
            ]
        ]);
        $form = FormUtility::createForm($model_config);

        $this->assertEquals($form->getModelConfig(), $model_config);
    }

    public function test_pop_items()
    {
        $model_config = new ConfigContainer([
            'instance' => [
                'my-custom-instance:fname' => [],
                'my-custom-instance:lname' => [],
            ]
        ]);
        $form = FormUtility::createForm($model_config);

        $items = $form->getInstance()->getItems();

        $this->assertInstanceOf(MyCutsomInstance::class, $items->get('my-custom-instance:fname'));
        $this->assertInstanceOf(MyCutsomInstance::class, $items->get('my-custom-instance:lname'));
    }

    public function test_get()
    {
        $model_config = new ConfigContainer([
            'instance' => [
                'my-custom-instance:fname' => [
                    'value' => 'john',
                ],
            ],
            'actions' => [
                'my-custom-action:action-name' => [
                    'event' => 'load',
                ]
            ]
        ]);
        $form = FormUtility::createForm($model_config);

        $this->assertEquals('john', $form->get('instance.my-custom-instance:fname.value'));
        $this->assertEquals('def', $form->get('instance.my-custom-instance:fname.visible', 'def'));
        $this->assertInstanceOf(InputInterface::class, $form->get('instance.my-custom-instance:fname'));
        $this->assertInstanceOf(ActionInterface::class, $form->get('actions.my-custom-action:action-name'));
        $this->assertNull($form->get('instance.my-custom-instance:fname.not_defined'));
    }

    public function test_init_action()
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
        $this->assertInstanceOf(ActionInterface::class, $form->get('actions.my-custom-action:on-form-load'));
    }

    public function test_input_validation_with_custom_message()
    {
        $configContainer = new ConfigContainer([
            'instance' => [
                'my-custom-instance:fname' => [
                    'validations' => [
                        'not-null' => ['message' => 'custom error message'],
                    ]
                ],
                'my-custom-instance:lname' => [],
            ]
        ]);
        $form = FormUtility::createForm($configContainer);

        $this->assertFalse($form->validate());
        $this->assertEquals([
            'my-custom-instance:fname' => [
                'custom error message'
            ],
            'my-custom-instance:lname' => []
        ], $form->getErrors()->toArray());
    }

    public function test_submit_form()
    {
        $model_config = new ConfigContainer([
            'instance' => [
                'my-custom-instance:fname' => [],
                'my-custom-instance:lname' => [],
            ]
        ]);
        $form = FormUtility::createForm($model_config);
        $form->submit([
            'instance.my-custom-instance:fname' => 'john',
            'instance.my-custom-instance:lname' => 'doe',
        ]);

        $this->assertEquals('john', $form->get('instance.my-custom-instance:fname.value'));

        $this->assertEquals($form->getModelConfig(), $model_config);
    }

    public function test_validation_for_form()
    {
        $model_config = new ConfigContainer([
            'instance' => [
                'my-custom-instance:fname' => [],
                'my-custom-instance:lname' => [],
            ],
            'actions' => [
                'validate:submit' => [
                    'event' => 'form.submit',
                ]
            ]
        ]);
        $form = FormUtility::createForm($model_config);
        $form->submit([
            'instance.my-custom-instance:fname' => 'john',
            'instance.my-custom-instance:lname' => 'doe',
        ]);

        $this->assertTrue($form->isSubmitted());
        $this->assertEquals($form->getModelConfig(), $model_config);
    }
}