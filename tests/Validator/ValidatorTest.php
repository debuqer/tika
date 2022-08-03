<?php


namespace Debuqer\TikaFormBuilder\Tests\Validator;


use Debuqer\TikaFormBuilder\DataStructure\Contracts\ValidationManagerInterface;
use Debuqer\TikaFormBuilder\Validation\ValidationManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

class ValidatorTest extends TestCase
{
    /** @var ValidationManagerInterface */
    protected $validator;

    public function setUp(): void
    {
        $this->validator = new ValidationManager();
    }

    public function test_simple_validation()
    {
        $this->validator->validate([
            'a' => 'hello',
        ], [
            'a' => [
                'not-null' => [],
            ]
        ]);

        $this->assertTrue($this->validator->isValid());
    }
}