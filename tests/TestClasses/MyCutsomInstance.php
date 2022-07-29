<?php
namespace Debuqer\TikaFormBuilder\Tests\TestClasses;

use Debuqer\TikaFormBuilder\Instance\Inputs\BaseInput;

class MyCutsomInstance extends BaseInput
{
    public function getName()
    {
        return 'custom_provider';
    }
}