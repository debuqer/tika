<?php


namespace Debuqer\Tika\DataStructure\DataContainers;


use Arrayy\Arrayy;

class BaseDataContainer
{
    protected array $data;
    protected Arrayy $dataContainer;

    public function __construct($data = [])
    {
        $this->data = $data;

        $this->dataContainer = Arrayy::create($this->data);
    }

    public function get($key, $fallback = null)
    {
        return $this->dataContainer->get($key, $fallback);
    }

    public function set($key, $value)
    {
        $this->dataContainer->set($key, $value);
    }

    public function merge($array)
    {
        $this->dataContainer = $this->dataContainer->mergeAppendNewIndex($array);
    }


    public function toArray()
    {
        return $this->dataContainer->toArray();
    }

    public function all()
    {
        return $this->toArray();
    }

    public function has($key)
    {
        return $this->dataContainer->has($key);
    }
}