<?php


namespace Debuqer\TikaFormBuilder\Tests\DataStructure;


use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;
use Debuqer\TikaFormBuilder\DataStructure\ExpressionEvaluator;
use Debuqer\TikaFormBuilder\Tests\Utils\FormUtility;

class ExpressionLanguageTest extends \PHPUnit\Framework\TestCase
{
    public function test_works()
    {
        $expressionLanguage = new ExpressionEvaluator();

        $configContainer = new ConfigContainer([
            'instance' => [
                'my-custom-instance:name' => [
                    'value' => 'Debuqer'
                ],
                'my-custom-instance:age' => [
                    'value' => 25
                ],
            ],
            'meta' => [
                'current_year' => 2022
            ]
        ]);

        $form = FormUtility::createForm($configContainer);
        $data = [
            'form' => $form
        ];

        $this->assertEquals(1997, $expressionLanguage->evaluate(
            'form.get("meta.current_year") - form.get("instance.my-custom-instance:age.value")'
        , $data));
        $this->assertEquals(6, $expressionLanguage->evaluate('2 + 4', []));
        $this->assertEquals("Hello  Debuqer", $expressionLanguage->evaluate(
            '"Hello " ~" "~ form.get("instance.my-custom-instance:name.value")', $data));
    }
}