<?php


namespace Debuqer\Tika\Items\InputTypes;


use Debuqer\Tika\Items\BaseItem;
use Debuqer\Tika\Items\Attributes\AttributeInterface;

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
        return [
            'attributes' => $this->getAttributesSchema()
        ];
    }

    /**
     * @param array $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @param $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attributes[] = $attribute;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    protected function getAttributesSchema()
    {
        $attributes = [];
        foreach ($this->attributes as $attribute) {
            $attributeProviderClass = $attribute['provider'];
            /**
             * @var AttributeInterface $attributeProvider
             */
            $attributeProvider = new $attributeProviderClass($attribute['params']);

            $attributes = array_merge($attributes, $attributeProvider->getSchema());
        }

        return $attributes;
    }
}