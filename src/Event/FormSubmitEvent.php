<?php


namespace Debuqer\Tika\Event;



class FormSubmitEvent extends BaseEvent
{
    public function getName()
    {
        return 'form.submit';
    }
}