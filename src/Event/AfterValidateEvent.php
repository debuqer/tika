<?php


namespace Debuqer\Tika\Event;



class AfterValidateEvent extends BaseEvent
{
    public function getName()
    {
        return 'form.validate.after';
    }
}