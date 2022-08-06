<?php


namespace Debuqer\TikaFormBuilder\Tests\Validator;


use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\DataStructure\Contracts\ValidationManagerInterface;
use Debuqer\TikaFormBuilder\Form;
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

    public function test_validator_asserts_all_fields()
    {
        $this->validator->validate([
            'a' => true,
            'b' => true,
        ], [
            'a' => [
                'is-true' => [],
            ],
            'b' => [
                'is-false' => [],
            ]
        ]);

        $this->assertFalse($this->validator->isValid());
    }

    public function test_validation_in_form()
    {
        $model_config = new ConfigContainer([
            'instance' => [
                'text:fname' => [
                    'validations' => ['not-null' => []],
                ],
                'text:lname' => [
                    'validations' => ['not-null' => []],
                ],
            ]
        ]);

        $form = new Form($model_config);
        $is_valid = $form->validate();

        $this->assertFalse($is_valid);
    }
}