<?php
namespace Debuqer\Tika;

use Debuqer\Tika\Items\Group;
use Debuqer\Tika\Items\ItemInterface;

class Form
{
    /**
     * Origin group containing whole the form
     *
     * @var Group $group
     */
    protected $group;

    /**
     * Form constructor.
     */
    public function __construct()
    {
        $this->group = new Group();

        $this->group->setName('main');
    }

    public function getSchema()
    {
        return [
            'items' => $this->group->getSchema()
        ];
    }

    /**
     * @return Group
     */
    public function getContainer()
    {
        return $this->group;
    }
}