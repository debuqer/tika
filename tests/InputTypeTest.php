<?php


class InputTypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Debuqer\Tika\Items\InputTypes\Input
     */
    protected $input;

    public function setUp(): void
    {
        parent::setUp();

        $this->input = new \Debuqer\Tika\Items\InputTypes\Input([]);
    }

    /**
     * @test
     */
    public function test_accept_attribute()
    {
        $attributes = [
            [
                'provider' => \Debuqer\Tika\Items\InputTypes\Attributes\AcceptAttribute::class,
                'params' => 'file_extension'
            ]
        ];

        $this->input->setAttributes($attributes);

        $this->assertArrayHasKey('accept', $this->input->getSchema()['attributes']);
    }
}