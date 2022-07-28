<?php
namespace Debuqer\TikaFormBuilder\Action;

use Debuqer\TikaFormBuilder\Form;

interface ActionInterface
{
    public function run(Form &$form);
}