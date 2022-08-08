<?php


namespace Debuqer\Tika\Tests\TestClasses;


use Debuqer\Tika\Form;

class MyCustomAction extends \Debuqer\Tika\Action\Types\BaseAction
{

    public function run(Form &$form)
    {
        $form->get('meta')->set('custom-action-executed', true);
    }
}