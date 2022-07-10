<?php


namespace Debuqer\Tika\Items\Attributes;


class OptionsAttribute extends BaseAttribute
{
    /**
     * @var array
     */
    protected $params;

    public function getSchema()
    {
        return [
            'options' => $this->getParam(0),
        ];
    }
}