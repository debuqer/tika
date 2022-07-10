<?php


namespace Debuqer\Tika\Items\InputTypes;


use Debuqer\Tika\Items\Attributes\TypeAttribute;

class SelectInput extends Input
{
    protected $attributes = [
        ['provider' => TypeAttribute::class, 'params' => 'text']
    ];
}