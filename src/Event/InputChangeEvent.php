<?php


namespace Debuqer\TikaFormBuilder\Event;



class InputChangeEvent extends BaseEvent
{
    public function getName()
    {
        return 'input.change';
    }
}