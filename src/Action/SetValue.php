<?php


namespace Debuqer\TikaFormBuilder\Action;


use Debuqer\TikaFormBuilder\Form;

class SetValue extends BaseAction
{
    public function run(Form &$form)
    {
        $fieldName = $this->getParameters()->get('field');
        $attribute = $this->getParameters()->get('attribute');

        $target = $this->getParameters()->get('value');

        $form->getInstance()->getItems()->get($fieldName)->setProperty($attribute, $target);
    }
}