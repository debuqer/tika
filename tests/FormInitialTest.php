<?php


namespace Debuqer\TikaFormBuilder\Tests;


use Debuqer\TikaFormBuilder\Tests\Utils\FormUtility;

class FormInitialTest extends BasicTestClass
{
    protected $utils_list = ['form'];

    public function test_init_form()
    {
        $form = FormUtility::createForm();

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
        $form = FormUtility::createForm($model_config);

        $this->assertEquals($form->getModelConfig(), $model_config);
    }
}