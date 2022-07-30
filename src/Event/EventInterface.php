<?php


namespace Debuqer\TikaFormBuilder\Event;

interface EventInterface extends \SplSubject
{
    public function getName();
}