<?php
namespace Debuqer\TikaFormBuilder\Tests\Utils;

class FormUtility
{
    public function createForm($payload = [])
    {
        return new Debuqer\TikaFormBuilder\Form($payload);
    }
}