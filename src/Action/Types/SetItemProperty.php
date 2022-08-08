<?php


namespace Debuqer\Tika\Action\Types;


use Debuqer\Tika\Exceptions\InvalidActionConfiguration;
use Debuqer\Tika\Exceptions\NotPropertySettingSupport;
use Debuqer\Tika\Form;
use Debuqer\Tika\Instance\Inputs\Functionalities\SetPropertyInterface;

class SetItemProperty extends BaseAction
{
    public function validate()
    {
        if( ! $this->getParameters()->has('item') ) {
            throw new InvalidActionConfiguration(sprintf('action %s must have item', $this->getName()));
        }

        if( ! $this->getParameters()->has($this->getValueContainerAttributeName()) ) {
            throw new InvalidActionConfiguration(sprintf('action %s must have %s', $this->getName(), $this->getValueContainerAttributeName()));
        }

        parent::validate();
    }

    public function run(Form &$form)
    {
        $fieldName = $this->getParameters()->get('item', null);
        $expr = $this->getParameters()->get($this->getValueContainerAttributeName(), $this->getPropertyDefaultValue());

        $value = $this->expressionLanguage->evaluate($expr, [
            'form' => $form,
        ]);

        $item = $form->get($fieldName);
        if( class_implements($item, SetPropertyInterface::class) ) {
            $form->get($fieldName)->setProperty($this->getPropertyName(), $value);
        } else {
            throw new NotPropertySettingSupport(sprintf('Item %s does not implements SetPropertyInterface', $fieldName));
        }
    }

    public function getPropertyName()
    {
        return 'value';
    }

    public function getPropertyDefaultValue()
    {
        return true;
    }

    public function getValueContainerAttributeName()
    {
        return 'value';
    }
}