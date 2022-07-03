<?php


class InputTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function test_fresh_input_schema_has_attributes_index()
    {
        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);

        $this->assertArrayHasKey('attributes', $item->getSchema());
    }

    /**
     * @test
     */
    public function test_input_name_set_properly()
    {
        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);
        $item->setName('myInputName');

        $this->assertEquals('myInputName', $item->getName());
    }

    /**
     * @test
     */
    public function test_input_label_set_properly()
    {
        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);
        $item->setLabel('myInputLabel');

        $this->assertEquals('myInputLabel', $item->getLabel());
    }

    /**
     * @test
     */
    public function test_input_attributes_works_properly()
    {
        $attributes = [
            ['provider' => \Debuqer\Tika\Items\Attributes\AcceptAttribute::class, 'params' => 'file_extension']
        ];

        $item = new \Debuqer\Tika\Items\InputTypes\Input($attributes);

        $schema = $item->getSchema();

        $this->assertNotEmpty($schema);
        $this->assertArrayHasKey('attributes', $schema);
    }
}