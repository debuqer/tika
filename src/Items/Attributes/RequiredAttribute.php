<?php


namespace Debuqer\Tika\Items\Attributes;


class RequiredAttribute extends BaseAttribute
{
    /**
     * @var array
     */
    protected $params;

    public function getSchema()
    {
        return [
            'required' => $this->getParam(0),
        ];
    }
}