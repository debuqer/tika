<?php
namespace Debuqer\Tika\Instance\Inputs;

class EmailInput extends BaseInput
{
    public function getItemValidations()
    {
        return [
            'email' => []
        ];
    }
}