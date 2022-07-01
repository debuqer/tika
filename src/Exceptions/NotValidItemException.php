<?php


namespace Debuqer\Tika\Exceptions;


class NotValidItemException extends \Exception
{
    protected $message = 'Item must implements Debuqer\Tika\ItemInterface';
}