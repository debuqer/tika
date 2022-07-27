<?php


namespace Debuqer\TikaFormBuilder\Tests;


class FormInitialTest extends BasicTestClass
{
    protected $utils_list = ['form'];

    public function test_init_form()
    {
        $form = $this->utils['form']->createForm();

        $this->assertNotNull($form);
    }

    public function test_load_model()
    {
        $model_config = [
            'instance' => [
                'input:fname' => [],
                'input:lname' => [],
            ]
        ];

        $form = $this->utils['form']->createForm($model_config);

        $this->assertEquals($form->getModelConfig(), $model_config);
    }
}