<?php


class FormTest extends \PHPUnit\Framework\TestCase
{
    public function testAddItemToFormWorks()
    {
        $form = new \Debuqer\Tika\Form();

        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);

        $form->getBody()->append($item->setName('a'));
        $form->getBody()->append($item->setName('b'));
        $form->getBody()->append($item->setName('c'));
        $form->getBody()->append($item->setName('d'));
        $form->getBody()->append($item->setName('e'));

        $schema = $form->getSchema();

        $this->assertArrayHasKey('body', $schema);
        $this->assertEquals(5, count($schema['body']['items']));

        foreach ($schema['body']['items'] as $itemSchema) {
            $this->assertEquals($itemSchema, $item->getSchema());
        }
    }

    public function testRemoveItem()
    {
        $form = new \Debuqer\Tika\Form();

        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);

        $form->getBody()->append($item->setName('a'));
        $form->getBody()->append($item->setName('b'));
        $form->getBody()->append($item->setName('c'));
        $form->getBody()->append($item->setName('d'));
        $form->getBody()->append($item->setName('e'));

        $form->getBody()->removeItemByName('a');

        $schema = $form->getSchema();
        $this->assertEquals(4, count($schema['body']['items']));
        $this->assertArrayNotHasKey('a', $schema['body']['items']);

        $form->getBody()->removeItemByName('b');

        $schema = $form->getSchema();
        $this->assertEquals(3, count($schema['body']['items']));
        $this->assertArrayNotHasKey('b', $schema['body']);
    }

    public function testNotThrowingExceptionForNotExistingItem()
    {
        $form = new \Debuqer\Tika\Form();

        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);

        $form->getBody()->append($item->setName('a'));
        $form->getBody()->removeItemByName('b');

        $schema = $form->getSchema();
        $this->assertEquals(1, count($schema['body']['items']));
        $this->assertArrayNotHasKey('b', $schema['body']['items']);
    }

    public function testFormSchemaIncludesAllItems()
    {
        $form = new \Debuqer\Tika\Form();

        $itemNames = ['a', 'b', 'c', 'd', 'e'];

        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);

        foreach ($itemNames as $itemName) {
            $form->getBody()->append($item->setName($itemName));
        }

        $this->assertIsArray($form->getSchema());
        $this->assertArrayHasKey('body', $form->getSchema());
        foreach ($itemNames as $itemName) {
            $this->assertArrayHasKey($itemName, $form->getSchema()['body']['items']);
            $this->assertEquals($item->getSchema(), $form->getSchema()['body']['items'][$itemName]);
        }
    }

    public function testGroupsCanBeAddedToForm()
    {
        $form = new \Debuqer\Tika\Form();
        $group1 = new \Debuqer\Tika\Items\Group();
        $group2 = new \Debuqer\Tika\Items\Group();
        $group3 = new \Debuqer\Tika\Items\Group();

        $form->getBody()->append($group1->setName('g1'));
        $form->getBody()->append($group2->setName('g2'));
        $form->getBody()->append($group3->setName('g3'));


        $this->assertEquals(3, count($form->getSchema()['body']['items']));

        $this->assertEquals($group1->getSchema(), $form->getSchema()['body']['items']['g1']);
        $this->assertEquals($group2->getSchema(), $form->getSchema()['body']['items']['g2']);
        $this->assertEquals($group3->getSchema(), $form->getSchema()['body']['items']['g3']);
    }

    public function testNestedGroup()
    {
        $form = new \Debuqer\Tika\Form();
        $group1 = new \Debuqer\Tika\Items\Group();
        $group11 = new \Debuqer\Tika\Items\Group();
        $group12 = new \Debuqer\Tika\Items\Group();
        $group2 = new \Debuqer\Tika\Items\Group();
        $group21 = new \Debuqer\Tika\Items\Group();

        $group1->append($group11->setName('g1.1'));
        $group1->append($group12->setName('g1.2'));
        $group2->append($group21->setName('g2.1'));

        $form->getBody()->append($group1->setName('g1'));
        $form->getBody()->append($group2->setName('g2'));

        $this->assertEquals(2, count($form->getSchema()['body']['items']));

        $this->assertEquals($group1->getSchema(), $form->getSchema()['body']['items']['g1']);
        $this->assertEquals($group2->getSchema(), $form->getSchema()['body']['items']['g2']);

        $group1Schema = $group1->getSchema();
        $group2Schema = $group2->getSchema();

        $this->assertEquals($group1Schema, $form->getSchema()['body']['items']['g1']);
        $this->assertEquals($group2Schema, $form->getSchema()['body']['items']['g2']);
    }
}