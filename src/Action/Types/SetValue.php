<?php


namespace Debuqer\TikaFormBuilder\Action\Types;


use Debuqer\TikaFormBuilder\Exceptions\InvalidActionConfiguration;
use Debuqer\TikaFormBuilder\Exceptions\NotPropertySettingSupport;
use Debuqer\TikaFormBuilder\Form;
use Debuqer\TikaFormBuilder\Instance\Inputs\Functionalities\SetPropertyInterface;

class SetValue extends BaseAction
{
    public function validate()
    {
        if( ! $this->getParameters()->has('item') ) {
            throw new InvalidActionConfiguration(sprintf('action %s must have item', $this->getName()));
        }

        if( ! $this->getParameters()->get('value') ) {
            throw new InvalidActionConfiguration(sprintf('action %s must have field', $this->getName()));
        }

        parent::validate();
    }

    public function run(Form &$form)
    {
        $fieldName = $this->getParameters()->get('item', null);
        $property = $this->getParameters()->get('property', 'value');

        $expr = $this->getParameters()->get('value');

        $value = $this->expressionLanguage->evaluate($expr, [
            'form' => $form,
        ]);

        $item = $form->get($property);
        if( class_implements($item, SetPropertyInterface::class) ) {
            $form->get($fieldName)->setProperty($property, $value);
        } else {
            throw new NotPropertySettingSupport(sprintf('Item %s does not implements SetPropertyInterface', $fieldName));
        }
    }
}