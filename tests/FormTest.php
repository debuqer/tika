<?php


class FormTest extends \PHPUnit\Framework\TestCase
{
    public function testAddItemToFormWorks()
    {
        $form = new \Debuqer\Tika\Form();

        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);

        $form->getContainer()->append($item->setName('a'));
        $form->getContainer()->append($item->setName('b'));
        $form->getContainer()->append($item->setName('c'));
        $form->getContainer()->append($item->setName('d'));
        $form->getContainer()->append($item->setName('e'));

        $schema = $form->getSchema();

        $this->assertArrayHasKey('items', $schema);
        $this->assertEquals(5, count($schema['items']));

        foreach ($schema['items'] as $itemSchema) {
            $this->assertEquals($itemSchema, $item->getSchema());
        }
    }

    public function testRemoveItem()
    {
        $form = new \Debuqer\Tika\Form();

        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);

        $form->getContainer()->append($item->setName('a'));
        $form->getContainer()->append($item->setName('b'));
        $form->getContainer()->append($item->setName('c'));
        $form->getContainer()->append($item->setName('d'));
        $form->getContainer()->append($item->setName('e'));

        $form->getContainer()->removeItemByName('a');

        $schema = $form->getSchema();
        $this->assertEquals(4, count($schema['items']));
        $this->assertArrayNotHasKey('a', $schema['items']);

        $form->getContainer()->removeItemByName('b');

        $schema = $form->getSchema();
        $this->assertEquals(3, count($schema['items']));
        $this->assertArrayNotHasKey('b', $schema['items']);
    }

    public function testNotThrowingExceptionForNotExistingItem()
    {
        $form = new \Debuqer\Tika\Form();

        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);

        $form->getContainer()->append($item->setName('a'));
        $form->getContainer()->removeItemByName('b');

        $schema = $form->getSchema();
        $this->assertEquals(1, count($schema['items']));
        $this->assertArrayNotHasKey('b', $schema['items']);
    }
}