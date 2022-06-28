<?php


class ItemTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function test_fresh_item_schema_is_empty()
    {
        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);

        $this->assertEmpty($item->getSchema());
    }

    /**
     * @test
     */
    public function test_fresh_item_name_is_empty()
    {
        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);

        $this->assertEmpty($item->getName());
    }

    /**
     * @test
     */
    public function test_fresh_item_label_is_empty()
    {
        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);

        $this->assertEmpty($item->getLabel());
    }

    /**
     * @test
     */
    public function test_item_name_set_properly()
    {
        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);
        $item->setName('myInputName');

        $this->assertEquals('myInputName', $item->getName());
    }

    /**
     * @test
     */
    public function test_item_label_set_properly()
    {
        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);
        $item->setLabel('myInputLabel');

        $this->assertEquals('myInputLabel', $item->getLabel());
    }

    /**
     * @test
     */
    public function test_item_attributes_works_properly()
    {
        $attributes = [
            ['provider' => \Debuqer\Tika\Items\InputTypes\Attributes\AcceptAttribute::class, 'params' => 'file_extension']
        ];

        $item = new \Debuqer\Tika\Items\InputTypes\Input($attributes);

        $schema = $item->getSchema();

        $this->assertNotEmpty($schema);
        $this->assertArrayHasKey('accept', $schema);
    }
}