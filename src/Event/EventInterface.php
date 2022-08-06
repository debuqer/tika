<?php


namespace Debuqer\Tika\Event;

interface EventInterface extends \SplSubject
{
    public function getName();
}