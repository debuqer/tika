<?php


namespace Debuqer\TikaFormBuilder\Event;



class InstanceChangeEvent extends BaseEvent
{
    public function getName()
    {
        return 'instance.change';
    }
}