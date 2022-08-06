<?php


namespace Debuqer\Tika\Event;



class InstanceChangeEvent extends BaseEvent
{
    public function getName()
    {
        return 'instance.change';
    }
}