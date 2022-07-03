<?php


namespace Debuqer\Tika\Items\Attributes;


class MaxAttribute extends BaseAttribute
{
    /**
     * @var array
     */
    protected $params;

    public function getSchema()
    {
        return [
            'max' => $this->getParam(0),
        ];
    }
}