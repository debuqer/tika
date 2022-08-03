<?php


namespace Debuqer\TikaFormBuilder\DataStructure\Contracts;


interface ValidationManagerInterface
{
    public function validate($data, $rules = []);
    public function isValid();
}