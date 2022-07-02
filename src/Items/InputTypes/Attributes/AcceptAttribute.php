<?php


namespace Debuqer\Tika\Items\InputTypes\Attributes;


class AcceptAttribute extends BaseAttribute
{
    /**
     * @var array
     */
    protected $params;

    public function getSchema()
    {
        return [
            'accept' => $this->getParam(0),
        ];
    }
}