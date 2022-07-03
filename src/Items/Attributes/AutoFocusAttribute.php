<?php


namespace Debuqer\Tika\Items\Attributes;


class AutoFocusAttribute extends BaseAttribute
{
    /**
     * @var array
     */
    protected $params;

    public function getSchema()
    {
        return [
            'auto_focus' => true,
        ];
    }
}