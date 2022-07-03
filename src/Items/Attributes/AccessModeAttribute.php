<?php


namespace Debuqer\Tika\Items\Attributes;


class AccessModeAttribute extends BaseAttribute
{
    /**
     * @var array
     */
    protected $params;

    public function getSchema()
    {
        return [
            'access_mode' => $this->getParam(0),
        ];
    }
}