<?php


namespace Debuqer\Tika\Items\Attributes;


class NameAttribute extends BaseAttribute
{
    /**
     * @var array
     */
    protected $params;

    public function getSchema()
    {
        return [
            'name' => $this->getParam(0),
        ];
    }
}