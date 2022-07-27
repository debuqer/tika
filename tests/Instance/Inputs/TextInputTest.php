<?php

class TextInputTest extends \PHPUnit\Framework\TestCase
{
    protected $utils_list = ['input'];

    public function test_text_load()
    {
        $name = 'foo';
        $model = [

        ];
        $input = \Debuqer\TikaFormBuilder\Tests\Utils\InputUtility::create('text', $name, $model);

        $this->assertNotNull($input);
    }

    public function test_text_name_works()
    {
        $name = 'foo';
        $model = [

        ];
        $input = \Debuqer\TikaFormBuilder\Tests\Utils\InputUtility::create('text', $name, $model);

        $this->assertEquals('foo', $input->getName());
    }

    public function test_text_config_works()
    {
        $name = 'foo';
        $model = [

        ];
        $input = \Debuqer\TikaFormBuilder\Tests\Utils\InputUtility::create('text', $name, $model);

        $this->assertEquals(Arrayy\create($model), $input->getModelConfig());
    }

    public function test_can_add_any_property()
    {
        $name = 'foo';
        $model = [
            'custom_property' => [
                'custom_inner_property' => 'bar'
            ]
        ];

        $input = \Debuqer\TikaFormBuilder\Tests\Utils\InputUtility::create('text', $name, $model);

        $this->assertEquals('bar', $input->getProperty('custom_property.custom_inner_property'));
    }
}