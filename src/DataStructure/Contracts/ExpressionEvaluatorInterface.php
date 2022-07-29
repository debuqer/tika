<?php


namespace Debuqer\TikaFormBuilder\DataStructure\Contracts;


interface ExpressionEvaluatorInterface
{
    public function evaluate(string $expr, array $data);
}