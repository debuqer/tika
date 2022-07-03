<?php


namespace Debuqer\Tika\Items\Attributes;


class PlaceHolderAttribute extends BaseAttribute
{
    /**
     * @var array
     */
    protected $params;

    public function getSchema()
    {
        return [
            'place_holder' => $this->getParam(0),
        ];
    }
}