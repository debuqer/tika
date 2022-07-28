<?php


namespace Debuqer\TikaFormBuilder\Action;


use Debuqer\TikaFormBuilder\Form;

class SetValue extends BaseAction
{
    public function run(Form &$form)
    {
        $fieldName = $this->getParameters()->get('field_name');
        $attribute = $this->getParameters()->get('attribute');

        $target = $this->getParameters()->get('target');

        $form->getIntance()->getItems()->get($fieldName)->setProperty($attribute, $target);
    }
}