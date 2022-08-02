<?php


namespace Debuqer\TikaFormBuilder\Action\Types;


use Debuqer\TikaFormBuilder\Exceptions\InvalidActionConfiguration;
use Debuqer\TikaFormBuilder\Exceptions\NotPropertySettingSupport;
use Debuqer\TikaFormBuilder\Form;
use Debuqer\TikaFormBuilder\Instance\Inputs\Functionalities\SetPropertyInterface;

class SetItemVisibleStatus extends BaseAction
{
    public function validate()
    {
        if( ! $this->getParameters()->has('item') ) {
            throw new InvalidActionConfiguration(sprintf('action %s must have item', $this->getName()));
        }

        if( ! $this->getParameters()->has('status') ) {
            throw new InvalidActionConfiguration(sprintf('action %s must have status', $this->getName()));
        }

        parent::validate();
    }

    public function run(Form &$form)
    {
        $fieldName = $this->getParameters()->get('item', null);
        $status = $this->getParameters()->get('status', true);

        $item = $form->get($fieldName);
        if( class_implements($item, SetPropertyInterface::class) ) {
            $form->get($fieldName)->setProperty('visible', $status);
        } else {
            throw new NotPropertySettingSupport(sprintf('Item %s does not implements SetPropertyInterface', $fieldName));
        }
    }
}