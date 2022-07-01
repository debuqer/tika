<?php


class FormTest extends \PHPUnit\Framework\TestCase
{
    public function testAddItemToFormWorks()
    {
        $form = new \Debuqer\Tika\Form();

        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);

        $form->setItem($item->setName('a'));
        $form->setItem($item->setName('b'));
        $form->setItem($item->setName('c'));
        $form->setItem($item->setName('d'));
        $form->setItem($item->setName('e'));

        $schema = $form->getSchema();

        $this->assertArrayHasKey('items', $schema);
        $this->assertEquals(5, count($schema['items']));

        foreach ($schema['items'] as $itemSchema) {
            $this->assertEquals($itemSchema, $item->getSchema());
        }
    }
}