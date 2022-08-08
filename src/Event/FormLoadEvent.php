<?php


namespace Debuqer\Tika\Event;



class FormLoadEvent extends BaseEvent
{
    public function getName()
    {
        return 'form.load';
    }
}