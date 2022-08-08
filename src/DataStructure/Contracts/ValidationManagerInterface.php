<?php


namespace Debuqer\Tika\DataStructure\Contracts;


interface ValidationManagerInterface
{
    public function validate($data, $rules = []);
    public function isValid();

    /**
     * [
     *      'field_name' => [ 'error_1', 'error_2', 'error_3'],
     * ]
     *
     * @return array
     */
    public function getErrors();
}