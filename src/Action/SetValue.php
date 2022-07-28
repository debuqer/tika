<?php


namespace Debuqer\TikaFormBuilder\Action;


use Debuqer\TikaFormBuilder\Exceptions\NotPropertySettingSupport;
use Debuqer\TikaFormBuilder\Form;

class SetValue extends BaseAction
{
    public function run(Form &$form)
    {
        $fieldAddress = $this->getParameters()->get('field');
        $address = explode('.', $fieldAddress);
        $fieldName = implode('.', array_slice($address, 0, sizeof($address) - 1));
        $fieldAttribute = $address[sizeof($address) - 1];

        $expr = $this->getParameters()->get('value');
        $value = $this->expressionLanguage->evaluate($expr, [
            'form' => $form,
        ]);

        $item = $form->get($fieldName);
        if( method_exists($item, 'setProperty') ) {
            $form->get($fieldName)->setProperty($fieldAttribute, $value);
        } else {
            throw new NotPropertySettingSupport(sprintf('Item %s does not have setProperty method', $fieldName));
        }
    }
}