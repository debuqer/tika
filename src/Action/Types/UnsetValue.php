<?php


namespace Debuqer\Tika\Action\Types;


use Debuqer\Tika\Exceptions\InvalidActionConfiguration;
use Debuqer\Tika\Exceptions\NotPropertySettingSupport;
use Debuqer\Tika\Form;
use Debuqer\Tika\Instance\Inputs\Functionalities\SetPropertyInterface;
use Debuqer\Tika\Instance\Inputs\Functionalities\UnsetPropertyInterface;

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