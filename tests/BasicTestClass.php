<?php
namespace Debuqer\TikaFormBuilder\Tests;

use Debuqer\TikaFormBuilder\Tests\Utils\FormUtility;

class BasicTestClass extends \PHPUnit\Framework\TestCase
{
    protected $utils;

    public function __construct()
    {
        foreach ($this->utils_list as $util) {
            if( $util == 'form' ) {
                $this->utils[$util] = new FormUtility();
            }
        }


        parent::__construct();
    }
}