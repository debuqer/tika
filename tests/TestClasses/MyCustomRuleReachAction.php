<?php


namespace Debuqer\TikaFormBuilder\Tests\TestClasses;


use Debuqer\TikaFormBuilder\Exceptions\InvalidActionConfiguration;
use Debuqer\TikaFormBuilder\Form;

class MyCustomRuleReachAction extends \Debuqer\TikaFormBuilder\Action\Types\BaseAction
{
    public function validate()
    {
        if( ! $this->getParameters()->has('required-attribute') ) {
            throw new InvalidActionConfiguration(sprintf('Action %s must has require-attribute', $this->getName()));
        }

        parent::validate();
    }

    public function run(Form &$form)
    {
        // action executes
    }
}