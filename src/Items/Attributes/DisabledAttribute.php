<?php


namespace Debuqer\Tika\Items\Attributes;


class DisabledAttribute extends BaseAttribute
{
    /**
     * @var array
     */
    protected $params;

    public function getSchema()
    {
        return [
            'disabled' => $this->getParam(0),
        ];
    }
}