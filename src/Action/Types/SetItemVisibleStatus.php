<?php


namespace Debuqer\TikaFormBuilder\Action\Types;


use Debuqer\TikaFormBuilder\Exceptions\InvalidActionConfiguration;
use Debuqer\TikaFormBuilder\Exceptions\NotPropertySettingSupport;
use Debuqer\TikaFormBuilder\Form;
use Debuqer\TikaFormBuilder\Instance\Inputs\Functionalities\SetPropertyInterface;

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