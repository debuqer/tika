<?php


namespace Debuqer\TikaFormBuilder\Event;



class FormLoadEvent extends BaseEvent
{
    public function getName()
    {
        return 'form.load';
    }
}