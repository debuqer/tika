<?php


namespace Debuqer\TikaFormBuilder\Tests;


use Debuqer\TikaFormBuilder\Action\Types\ActionInterface;
use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\Instance\Inputs\InputInterface;
use Debuqer\TikaFormBuilder\Instance\Inputs\TextInput;
use Debuqer\TikaFormBuilder\Tests\TestClasses\MyCutsomInstance;
use Debuqer\TikaFormBuilder\Tests\Utils\FormUtility;

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
                'my-custom:action-name' => [
                    'event' => 'load',
                ]
            ]
        ]);
        $form = FormUtility::createForm($model_config);

        $this->assertEquals('john', $form->get('instance.my-custom-instance:fname.value'));
        $this->assertEquals('def', $form->get('instance.my-custom-instance:fname.visible', 'def'));
        $this->assertInstanceOf(InputInterface::class, $form->get('instance.my-custom-instance:fname'));
        $this->assertInstanceOf(ActionInterface::class, $form->get('actions.my-custom:action-name'));
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
                'my-custom:on-form-load' => [
                    'event' => 'form.load',
                ],
            ],
        ]);

        $form = FormUtility::createForm($configContainer);
        $this->assertInstanceOf(ActionInterface::class, $form->get('actions.my-custom:on-form-load'));
    }
}