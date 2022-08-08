<?php


namespace Debuqer\Tika\Event;



class InputChangeEvent extends BaseEvent
{
    public function getName()
    {
        return 'input.change';
    }
}