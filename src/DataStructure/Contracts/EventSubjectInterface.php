<?php


namespace Debuqer\TikaFormBuilder\DataStructure\Contracts;


use Debuqer\TikaFormBuilder\Event\EventInterface;

interface EventSubjectInterface
{
    public function trigger(EventInterface $event);
}