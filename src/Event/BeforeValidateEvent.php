<?php


namespace Debuqer\Tika\Event;



class BeforeValidateEvent extends BaseEvent
{
    public function getName()
    {
        return 'form.validate.before';
    }
}