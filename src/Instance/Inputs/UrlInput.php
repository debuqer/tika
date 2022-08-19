<?php
namespace Debuqer\Tika\Instance\Inputs;

class UrlInput extends BaseInput
{
    public function getItemValidations()
    {
        return [
            'url' => []
        ];
    }
}