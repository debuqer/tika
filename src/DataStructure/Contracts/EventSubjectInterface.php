<?php


namespace Debuqer\Tika\DataStructure\Contracts;


use Debuqer\Tika\Event\EventInterface;

interface EventSubjectInterface
{
    public function trigger(EventInterface $event);
}