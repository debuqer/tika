<?php


namespace Debuqer\Tika\DataStructure\DataContainers;


use Debuqer\Tika\DataStructure\DataContainers\Instance\ParametersDataContainer;

class ActionDataContainer extends BaseDataContainer
{
    public function getName()
    {
        return $this->get('name');
    }

    public function getEvent()
    {
        return $this->get('event');
    }

    public function getParameters()
    {
        return new ParametersDataContainer($this->all());
    }

    public function getConditions()
    {
        return $this->get('conditions', 'true');
    }

    public function hasParameter($key)
    {
        return $this->has($key);
    }
}