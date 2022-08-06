<?php


namespace Debuqer\TikaFormBuilder\Event;



class BeforeValidateEvent extends BaseEvent
{
    public function getName()
    {
        return 'form.validate.before';
    }
}