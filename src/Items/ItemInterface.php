<?php


namespace Debuqer\Tika\Items;


interface ItemInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @return mixed
     */
    public function getSchema();
}