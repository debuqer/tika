<?php


namespace Debuqer\Tika\Action\Types;


use Debuqer\Tika\Exceptions\InvalidActionConfiguration;
use Debuqer\Tika\Exceptions\NotPropertySettingSupport;
use Debuqer\Tika\Form;
use Debuqer\Tika\Instance\Inputs\Functionalities\UnsetPropertyInterface;

class Validate extends BaseAction
{
    public function validate()
    {
        parent::validate();
    }

    public function run(Form &$form)
    {
        $form->validate();
    }
}