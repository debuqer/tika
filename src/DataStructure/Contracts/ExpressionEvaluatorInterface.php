<?php


namespace Debuqer\Tika\DataStructure\Contracts;


interface ExpressionEvaluatorInterface
{
    public function evaluate(string $expr, array $data);
}