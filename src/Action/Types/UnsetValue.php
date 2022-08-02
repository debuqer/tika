<?php


namespace Debuqer\TikaFormBuilder\Action\Types;


use Debuqer\TikaFormBuilder\Exceptions\InvalidActionConfiguration;
use Debuqer\TikaFormBuilder\Exceptions\NotPropertySettingSupport;
use Debuqer\TikaFormBuilder\Form;
use Debuqer\TikaFormBuilder\Instance\Inputs\Functionalities\SetPropertyInterface;
use Debuqer\TikaFormBuilder\Instance\Inputs\Functionalities\UnsetPropertyInterface;

class UnsetValue extends BaseAction
{
    public function validate()
    {
        if( ! $this->getParameters()->has('item') ) {
            throw new InvalidActionConfiguration(sprintf('action %s must have item', $this->getName()));
        }

        parent::validate();
    }

    public function run(Form &$form)
    {
        $fieldName = $this->getParameters()->get('item', null);
        $property = $this->getParameters()->get('property', 'value');

        $item = $form->get($fieldName);
        if( class_implements($item, UnsetPropertyInterface::class) ) {
            $form->get($fieldName)->unsetProperty($property);
        } else {
            throw new NotPropertySettingSupport(sprintf('Item %s does not implements UnsetPropertyInterface', $fieldName));
        }
    }
}