<?php


namespace Debuqer\TikaFormBuilder\Action\Types;


use Debuqer\TikaFormBuilder\Exceptions\InvalidActionConfiguration;
use Debuqer\TikaFormBuilder\Exceptions\NotPropertySettingSupport;
use Debuqer\TikaFormBuilder\Form;
use Debuqer\TikaFormBuilder\Instance\Inputs\Functionalities\SetPropertyInterface;

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