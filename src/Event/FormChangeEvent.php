<?php


namespace Debuqer\TikaFormBuilder\Event;



class FormChangeEvent extends BaseEvent
{
    public function getName()
    {
        return 'form.change';
    }
}