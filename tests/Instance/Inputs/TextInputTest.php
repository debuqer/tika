<?php

class TextInputTest extends \PHPUnit\Framework\TestCase
{
    protected $utils_list = ['input'];

    public function test_text_load()
    {
        $name = 'input:foo';
        $model = [

        ];

        $input = \Debuqer\TikaFormBuilder\Tests\Utils\InputUtility::create('text', $name, $model);
        $this->assertNotNull($input);
    }
}