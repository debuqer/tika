<?php


namespace Debuqer\Tika\Items\Attributes;


class ValueAttribute extends BaseAttribute
{
    /**
     * @var array
     */
    protected $params;

    public function getSchema()
    {
        return [
            'value' => $this->getParam(0),
        ];
    }
}