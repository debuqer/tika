<?php


namespace Debuqer\TikaFormBuilder\Tests;


class FormInitialTest extends BasicTestClass
{
    protected $utils_list = ['form'];

    public function test_init_form()
    {
        $this->utils['form']->createForm();
    }
}