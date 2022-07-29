<?php


namespace Debuqer\TikaFormBuilder\DataStructure;


use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ExpressionEvaluator implements Contracts\ExpressionEvaluatorInterface
{
    /** @var ExpressionLanguage */
    protected $engine;

    public function __construct()
    {
        $this->engine = new ExpressionLanguage();
    }

    /**
     * @param string $expr
     * @param array $data
     * @return mixed
     */
    public function evaluate(string $expr, array $data)
    {
        return $this->engine->evaluate($expr, $data);
    }
}