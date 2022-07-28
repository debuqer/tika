<?php


class InstanceTest extends \PHPUnit\Framework\TestCase
{
    public function test_can_load_config()
    {
        $instance = $this->createInstance([
            'text:a' => [],
        ]);

        $this->assertNotNull($instance);
    }

    public function test_error_on_invalid_type()
    {
        $this->expectException(\Debuqer\TikaFormBuilder\Exceptions\NotValidItemIdKey::class);

        $this->createInstance([
            'invalid:a' => [],
        ]);
    }

    public function test_error_on_invalid_item_id()
    {
        $this->expectException(\Debuqer\TikaFormBuilder\Exceptions\NotValidItemIdKey::class);

        $this->createInstance([
            '' => [],
        ]);
    }

    public function test_error_on_invalid_item_id_3_section()
    {
        $this->expectException(\Debuqer\TikaFormBuilder\Exceptions\NotValidItemIdKey::class);

        $this->createInstance([
            'text:a:b' => [],
        ]);
    }

    public function test_create_items()
    {
        $instance = $this->createInstance([
            'text:a' => [],
        ]);

        $this->assertInstanceOf(
            \Debuqer\TikaFormBuilder\Instance\Inputs\TextInput::class,
            $instance->getItems()->get('text:a')
        );
    }

    public function test_error_on_invalid_config()
    {
        $this->expectException(\Debuqer\TikaFormBuilder\Exceptions\NotValidItemConfig::class);

        $this->createInstance([
            'text:a' => 'invalid_config_',
        ]);
    }

    protected function createInstance($config_array)
    {
        $config = new \Debuqer\TikaFormBuilder\DataStructure\ConfigContainer($config_array);

        return new Debuqer\TikaFormBuilder\Instance\Instance($config);
    }
}