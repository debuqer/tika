<?php
namespace Debuqer\TikaFormBuilder\Tests\Utils;

class FormUtility
{
    public function createForm($model_config = [])
    {
        return new \Debuqer\TikaFormBuilder\Form($model_config);
    }
}