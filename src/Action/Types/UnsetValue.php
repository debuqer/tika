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
        if( ! $this->getParameters()->has('field') ) {
            throw new InvalidActionConfiguration(sprintf('action %s must have field', $this->getName()));
        }

        parent::validate();
    }

    public function run(Form &$form)
    {
        $fieldAddress = $this->getParameters()->get('field', null);

        $address = explode('.', $fieldAddress);
        $fieldName = implode('.', array_slice($address, 0, sizeof($address) - 1));
        $fieldAttribute = $address[sizeof($address) - 1];

        $item = $form->get($fieldName);
        if( class_implements($item, UnsetPropertyInterface::class) ) {
            $form->get($fieldName)->unsetProperty($fieldAttribute);
        } else {
            throw new NotPropertySettingSupport(sprintf('Item %s does not implements UnsetPropertyInterface', $fieldName));
        }
    }
}