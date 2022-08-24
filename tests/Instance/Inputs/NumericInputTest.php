<?php

class NumericInputTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @TODO remove utils test
     */
    protected $utils_list = ['input'];

    public function test_text_load()
    {
        $name = 'foo';
        $config = new \Debuqer\Tika\DataStructure\ConfigContainer([]);
        $input = \Debuqer\Tika\Tests\Utils\InputUtility::create('numeric', $name, $config);

        $this->assertNotNull($input);
    }

    public function test_numeric_validation()
    {
        $model_config = [
            'instance' => [
                'numeric:age' => [],
            ]
        ];
        $form = \Debuqer\Tika\Tests\Utils\FormUtility::createForm($model_config);
        $form->get('instance.numeric:age')->setValue('hello');

        $form->validate();

        $this->assertFalse($form->isValid());
    }
}