<?php
namespace Debuqer\Tika\Instance\Inputs;

class TextInput extends BaseInput
{
    public function getItemValidations()
    {
        return [
            'type' => ['type' => 'string']
        ];
    }
}