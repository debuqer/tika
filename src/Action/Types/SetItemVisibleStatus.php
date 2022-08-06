<?php


namespace Debuqer\Tika\Action\Types;


use Debuqer\Tika\Exceptions\InvalidActionConfiguration;
use Debuqer\Tika\Exceptions\NotPropertySettingSupport;
use Debuqer\Tika\Form;
use Debuqer\Tika\Instance\Inputs\Functionalities\SetPropertyInterface;

class SetItemVisibleStatus extends SetItemProperty
{
    public function getPropertyName()
    {
        return 'visible';
    }

    public function getValueContainerAttributeName()
    {
        return 'status';
    }

    public function getPropertyDefaultValue()
    {
        return null;
    }
}