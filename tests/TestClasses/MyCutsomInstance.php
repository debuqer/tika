<?php
namespace Debuqer\Tika\Tests\TestClasses;

use Debuqer\Tika\Instance\Inputs\BaseInput;

class MyCutsomInstance extends BaseInput
{
    public function getName()
    {
        return 'custom_provider';
    }
}