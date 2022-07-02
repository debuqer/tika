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
            'body' => $this->group->getSchema()
        ];
    }

    /**
     * @return Group
     */
    public function getBody()
    {
        return $this->group;
    }

    /**
     * @param $itemAddressKey
     * @param null $default
     * @return array|mixed
     */
    public function getItemSchema($itemAddressKey, $default = null) {
        $schema = $this->getSchema();
        if ( $itemAddressKey === '' ) {
            return $schema;
        }

        $itemAddress = explode('.', $itemAddressKey);

        for ($depth = 0; $depth < count($itemAddress); $depth++) {
            if( $itemAddress[$depth] === 'count()') {
                return count($schema);
            }
            else if ( isset($schema[$itemAddress[$depth]]) ) {
                $schema = $schema[$itemAddress[$depth]];
            }
            else {
                return $default;
            }
        }

        return $schema;
    }
}