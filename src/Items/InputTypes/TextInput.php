<?php


namespace Debuqer\Tika\Items\InputTypes;


use Debuqer\Tika\Items\Attributes\AcceptAttribute;
use Debuqer\Tika\Items\Attributes\TypeAttribute;

class TextInput extends Input
{
    protected $attributes = [
        ['provider' => TypeAttribute::class, 'params' => 'text']
    ];
}