<?php
namespace Debuqer\Tika\Instance\Inputs;

class NumericInput extends BaseInput
{
    protected $type = 'integer';

    public function getItemValidations()
    {
        return [
            'type' => ['type' => $this->type],
        ];
    }
}