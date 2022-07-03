<?php


namespace Debuqer\Tika\Items\Attributes;


class TypeAttribute extends BaseAttribute
{
    /**
     * @var array
     */
    protected $params;

    public function getSchema()
    {
        return [
            'type' => $this->getParam(0),
        ];
    }
}