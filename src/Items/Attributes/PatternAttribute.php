<?php


namespace Debuqer\Tika\Items\Attributes;


class PatternAttribute extends BaseAttribute
{
    /**
     * @var array
     */
    protected $params;

    public function getSchema()
    {
        return [
            'pattern' => $this->getParam(0),
        ];
    }
}