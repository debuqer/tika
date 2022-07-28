<?php


namespace Debuqer\TikaFormBuilder\Action;


use Debuqer\TikaFormBuilder\Form;

class SetValue extends BaseAction
{
    public function run(Form &$form)
    {
        $fieldName = $this->getParameters()->get('field');
        $attribute = $this->getParameters()->get('attribute');

        $expr = $this->getParameters()->get('value');
        $value = $this->expressionLanguage->evaluate($expr, [
            'form' => $form,
        ]);

        $form->getInstance()->getItems()->get($fieldName)->setProperty($attribute, $value);
    }
}