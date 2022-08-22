<?php


namespace Debuqer\Tika\DataStructure\DataContainers;


use Arrayy\Arrayy;

class FormDataContainer extends BaseDataContainer
{
    public function getInstances()
    {
        return new InstanceDataContainer($this->get('instance', new Arrayy([]))->toArray());
    }

    public function getProviders()
    {
        return new ProvidersDataContainer($this->get('providers', new Arrayy([]))->toArray());
    }

    public function getActions()
    {
        return new ActionsDataContainer($this->get('actions', new Arrayy([]))->toArray());
    }

    public function getMeta()
    {
        return new MetaDataContainer($this->get('meta', new Arrayy([]))->toArray());
    }
}