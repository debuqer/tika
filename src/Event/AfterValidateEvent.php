<?php


namespace Debuqer\TikaFormBuilder\Event;



class AfterValidateEvent extends BaseEvent
{
    public function getName()
    {
        return 'form.validate.after';
    }
}