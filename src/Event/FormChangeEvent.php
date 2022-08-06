<?php


namespace Debuqer\Tika\Event;



class FormChangeEvent extends BaseEvent
{
    public function getName()
    {
        return 'form.change';
    }
}