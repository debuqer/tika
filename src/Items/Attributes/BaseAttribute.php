<?php


namespace Debuqer\Tika\Items\Attributes;


abstract class BaseAttribute implements AttributeInterface
{
    /**
     * @var array
     */
    protected $params;

    public function __construct(...$params)
    {
        $this->params = $params;
    }

    /**
     * @param $parameterNumber
     * @return mixed
     */
    public function getParam($parameterNumber)
    {
        return $this->params[$parameterNumber];
    }
}