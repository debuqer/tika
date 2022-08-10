<?php
namespace Debuqer\Tika\Instance\Inputs;

class NumericInput extends BaseInput
{
    public function getItemValidations()
    {
        return [
            'type' => ['type' => 'integer'],
        ];
    }
}