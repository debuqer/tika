<?php


namespace Debuqer\Tika\Items\Attributes;


class MinAttribute extends BaseAttribute
{
    /**
     * @var array
     */
    protected $params;

    public function getSchema()
    {
        return [
            'min' => $this->getParam(0),
        ];
    }
}