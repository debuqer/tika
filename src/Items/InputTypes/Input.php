<?php


namespace Debuqer\Tika\Items\InputTypes;


use Debuqer\Tika\Items\BaseItem;
use Debuqer\Tika\Items\InputTypes\Attributes\AttributeInterface;

class Input extends BaseItem
{
    /**
     * @var array
     */
    protected $attributes;

    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return array|mixed
     */
    public function getSchema()
    {
        $schema = [];

        foreach ($this->attributes as $attribute) {
            $attributeProviderClass = $attribute['provider'];
            /**
             * @var AttributeInterface $attributeProvider
             */
            $attributeProvider = new $attributeProviderClass($attribute['params']);

            $schema = array_merge($schema, $attributeProvider->getSchema());
        }

        return $schema;
    }
}