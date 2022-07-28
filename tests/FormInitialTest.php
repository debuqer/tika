<?php


namespace Debuqer\TikaFormBuilder\Tests;


use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\Instance\Inputs\TextInput;
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
                'text:fname' => [],
                'text:lname' => [],
            ]
        ]);
        $form = FormUtility::createForm($model_config);

        $this->assertEquals($form->getModelConfig(), $model_config);
    }

    public function test_pop_items()
    {
        $model_config = new ConfigContainer([
            'instance' => [
                'text:fname' => [],
                'text:lname' => [],
            ]
        ]);
        $form = FormUtility::createForm($model_config);

        $items = $form->getIntance()->getItems();

        $this->assertInstanceOf(TextInput::class, $items->get('text:fname'));
        $this->assertInstanceOf(TextInput::class, $items->get('text:lname'));
    }
}