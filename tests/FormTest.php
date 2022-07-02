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
        $this->assertEquals(5, count($form->getItemSchema('body.items')));

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
        $this->assertEquals(4, count($form->getItemSchema('body.items')));
        $this->assertArrayNotHasKey('a', $form->getItemSchema('body.items'));

        $form->getBody()->removeItemByName('b');

        $schema = $form->getSchema();
        $this->assertEquals(3, count($form->getItemSchema('body.items')));
        $this->assertArrayNotHasKey('b', $form->getItemSchema('body'));
    }

    public function testNotThrowingExceptionForNotExistingItem()
    {
        $form = new \Debuqer\Tika\Form();

        $item = new \Debuqer\Tika\Items\InputTypes\Input([]);

        $form->getBody()->append($item->setName('a'));
        $form->getBody()->removeItemByName('b');

        $schema = $form->getSchema();
        $this->assertEquals(1, count($form->getItemSchema('body.items')));
        $this->assertArrayNotHasKey('b', $form->getItemSchema('body.items'));
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
            $this->assertArrayHasKey($itemName, $form->getItemSchema('body.items'));
            $this->assertEquals($item->getSchema(), $form->getItemSchema('body.items.'.$itemName));
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


        $this->assertEquals(3, count($form->getItemSchema('body.items')));

        $this->assertEquals($group1->getSchema(), $form->getItemSchema('body.items.g1'));
        $this->assertEquals($group2->getSchema(), $form->getItemSchema('body.items.g2'));
        $this->assertEquals($group3->getSchema(), $form->getItemSchema('body.items.g3'));
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

        $group1Schema = $group1->getSchema();
        $group2Schema = $group2->getSchema();

        $this->assertEquals($group1Schema, $form->getItemSchema('body.items.g1'));
        $this->assertEquals($group2Schema, $form->getItemSchema('body.items.g2'));
    }

    public function testAddItemToNestedGroup()
    {
        $form = new \Debuqer\Tika\Form();

        $group = new \Debuqer\Tika\Items\Group();
        $group->setName('g');

        $item = new Debuqer\Tika\Items\InputTypes\Input([]);
        $item->setName('i1');
        $group->append($item);

        $form->getBody()->append($group);

        $this->assertEquals(1, count($form->getItemSchema('body.items.g.items')));
        $this->assertEquals($item->getSchema(), $form->getItemSchema('body.items.g.items.i1'));
    }

    public function testGetItemSchema()
    {
        $form = new \Debuqer\Tika\Form();

        $group = new \Debuqer\Tika\Items\Group();
        $group->setName('g');

        $attributes = [
            ['provider' => \Debuqer\Tika\Items\InputTypes\Attributes\AcceptAttribute::class, 'params' => 'file_extension']
        ];
        $item = new Debuqer\Tika\Items\InputTypes\Input($attributes);
        $item->setName('i1');
        $group->append($item);

        $form->getBody()->append($group);

        $this->assertEquals($group->getSchema(), $form->getItemSchema('body.items.g'));
        $this->assertEquals($item->getSchema(), $form->getItemSchema('body.items.g.items.i1'));
        $this->assertEquals('no_value', $form->getItemSchema('body.items.g.items.i2', 'no_value'));
    }

    public function testCountMethodOnGetItemSchema()
    {
        $form = new \Debuqer\Tika\Form();

        $group = new \Debuqer\Tika\Items\Group();
        $group->setName('g');

        $item = new Debuqer\Tika\Items\InputTypes\Input([]);
        $item->setName('i1');
        $group->append($item);

        $form->getBody()->append($group);

        $this->assertEquals(1, $form->getItemSchema('body.items.count()'));
        $this->assertEquals(1, $form->getItemSchema('body.items.g.items.count()'));
    }
}