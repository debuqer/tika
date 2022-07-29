<?php
namespace Debuqer\TikaFormBuilder\Tests\TestClasses;

use Debuqer\TikaFormBuilder\Instance\Inputs\BaseInput;

class MyCutsomProvider extends BaseInput
{
    public function getName()
    {
        return 'custom_provider';
    }
}