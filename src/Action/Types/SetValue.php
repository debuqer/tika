<?php


namespace Debuqer\Tika\Action\Types;


use Debuqer\Tika\Exceptions\InvalidActionConfiguration;
use Debuqer\Tika\Exceptions\NotPropertySettingSupport;
use Debuqer\Tika\Form;
use Debuqer\Tika\Instance\Inputs\Functionalities\SetPropertyInterface;

class SetValue extends SetItemProperty
{
    public function getPropertyName()
    {
        return 'value';
    }

    public function getValueContainerAttributeName()
    {
        return 'value';
    }

    public function getPropertyDefaultValue()
    {
        return null;
    }
}