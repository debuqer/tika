<?php


namespace Debuqer\Tika\Event;



class AfterInputChangeEvent extends BaseEvent
{
    public function getName()
    {
        return 'input.change.after';
    }
}