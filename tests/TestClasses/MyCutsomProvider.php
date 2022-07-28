<?php
namespace Debuqer\TikaFormBuilder\Tests\TestClasses;

use Debuqer\TikaFormBuilder\Instance\Inputs\InputInterface;

class MyCutsomProvider implements InputInterface
{
    public function getName()
    {
        return 'custom_provider';
    }
}