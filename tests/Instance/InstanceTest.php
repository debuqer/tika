<?php


class InstanceTest extends \PHPUnit\Framework\TestCase
{
    public function test_can_load_config()
    {
        $instance = $this->createInstance([
            'my-custom-instance:a' => [],
        ], []);

        $this->assertNotNull($instance);
    }

    public function test_error_on_invalid_type()
    {
        $this->expectException(\Debuqer\Tika\Exceptions\InvalidItemIdKey::class);

        $this->createInstance([
            'invalid:a' => [],
        ], []);
    }

    public function test_error_on_invalid_item_id()
    {
        $this->expectException(\Debuqer\Tika\Exceptions\InvalidItemIdKey::class);

        $this->createInstance([
            '' => [],
        ], []);
    }

    public function test_error_on_invalid_item_id_3_section()
    {
        $this->expectException(\Debuqer\Tika\Exceptions\InvalidItemIdKey::class);

        $this->createInstance([
            'my-custom-instance:a:b' => [],
        ], []);
    }

    public function test_create_items()
    {
        $instance = $this->createInstance([
            'my-custom-instance:a' => [],
        ], []);

        $this->assertInstanceOf(
            \Debuqer\Tika\Tests\TestClasses\MyCutsomInstance::class,
            $instance->getItems()->get('my-custom-instance:a')
        );
    }

    public function test_error_on_invalid_config()
    {
        $this->expectException(\Debuqer\Tika\Exceptions\InvalidItemConfig::class);

        $this->createInstance([
            'my-custom-instance:a' => 'invalid_config_',
        ], []);
    }

    public function test_pass_custom_provider()
    {
        $instance = $this->createInstance([
            'custom_provider:a' => [],
        ], [
            'instance:custom_provider' => \Debuqer\Tika\Tests\TestClasses\MyCutsomInstance::class
        ]);

        $this->assertNotNull($instance);
    }

    protected function createInstance($config_array, $providers_config)
    {
        $config = new \Debuqer\Tika\DataStructure\DataContainers\InstanceDataContainer($config_array);
        $providers = new \Debuqer\Tika\DataStructure\DataContainers\ProvidersDataContainer($providers_config);

        $providers->merge([
            'instance:my-custom-instance' => \Debuqer\Tika\Tests\TestClasses\MyCutsomInstance::class,
        ]);

        return new Debuqer\Tika\Instance\Instance($config, $providers);
    }
}