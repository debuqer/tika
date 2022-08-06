<?php


namespace Debuqer\Tika\Tests\TestClasses;


use Debuqer\Tika\Exceptions\InvalidActionConfiguration;
use Debuqer\Tika\Form;

class MyCustomRuleReachAction extends \Debuqer\Tika\Action\Types\BaseAction
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