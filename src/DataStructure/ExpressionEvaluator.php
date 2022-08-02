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
     * @param mixed $expr
     * @param array $data
     * @return mixed
     */
    public function evaluate($expr, array $data = [])
    {
        if ( is_bool($expr) ) {
            return $expr;
        }
        if( is_null($expr) ) {
            return $expr;
        }

        return $this->engine->evaluate($expr, $data);
    }
}