<?php
namespace Debuqer\Tika\Instance;

use Debuqer\Tika\DataStructure\ConfigContainer;
use Debuqer\Tika\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\Tika\DataStructure\Contracts\EventSubjectInterface;
use Debuqer\Tika\DataStructure\DataContainers\Instance\ItemsDataContainer;
use Debuqer\Tika\DataStructure\DataContainers\InstanceDataContainer;
use Debuqer\Tika\DataStructure\DataContainers\ProvidersDataContainer;
use Debuqer\Tika\Event\EventInterface;
use Debuqer\Tika\Event\AfterInputChangeEvent;
use Debuqer\Tika\Event\InstanceChangeEvent;
use Debuqer\Tika\Exceptions\InvalidInputProvider;
use Debuqer\Tika\Exceptions\InvalidItemConfig;
use Debuqer\Tika\Exceptions\InvalidItemIdKey;
use Debuqer\Tika\Form;
use Debuqer\Tika\Instance\Inputs\InputInterface;
use Debuqer\Tika\Instance\Inputs\TextInput;

class Instance implements EventSubjectInterface
{
    /**
     * @var ItemsDataContainer
     */
    protected ItemsDataContainer $items;
    /**
     * @var ConfigContainerInterface
     */
    protected $providers;
    /**
     * @var Form
     */
    protected $form;

    public function __construct(InstanceDataContainer $instanceConfig,
                                ProvidersDataContainer $providers
    )
    {
        $this->items = new ItemsDataContainer();
        $this->setProviders($providers);

        $items = $instanceConfig->toArray();
        /** @var InstanceDataContainer $item */
        foreach ($items as $itemId => $itemConfig) {
            if( !is_array($itemConfig) ) {
                throw new InvalidItemConfig(sprintf('Item %s config is not not valid', $itemId));
            }

            if ( $itemId == '' ) {
                throw new InvalidItemIdKey('ItemId must not be empty');
            }

            $itemIdSplited = explode(':', $itemId);
            $itemType = 'text';
            if ( count($itemIdSplited) == 2 ) {
                $itemType = $itemIdSplited[0];
                if( $itemType == '' ) {
                    $itemType = 'text';
                }
                $itemName = $itemIdSplited[1];
            } else if( count($itemIdSplited) == 1 ){
                $itemName = $itemIdSplited[0];
            } else {
                throw new InvalidItemIdKey('Item id must be satisfied by type:name or name or :name');
            }

            $itemProvider = $this->providers->get('instance:'.$itemType, null);
            if ( $itemProvider ) {
                if ( !class_implements($itemProvider, InputInterface::class) ) {
                    throw new InvalidInputProvider(sprintf('Item %s provider has not implemented InputInterface', $itemType));
                }

                /** @var InputInterface $item */
                $item = (new $itemProvider($itemName, new ConfigContainer($itemConfig)))
                            ->setInstance($this);
            } else {
                throw new InvalidItemIdKey(sprintf('Item %s type is not valid', $itemType));
            }

            $this->items->merge([$itemId => $item]);
        }
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setForm(Form &$form)
    {
        $this->form = $form;

        return $this;
    }

    public function getForm()
    {
        return $this->form;
    }

    protected function setProviders(ProvidersDataContainer $providers)
    {
        $this->providers = new ProvidersDataContainer([

        ]);

        foreach ($providers->all() as $customProviderKey => $customProviderClass) {
            if( strpos($customProviderKey, 'instance:') !== false ) {
                $this->providers->merge([$customProviderKey => $customProviderClass]);
            }
        }
    }

    public function trigger(EventInterface $event)
    {
        if ( $this->getForm() ) {
            if ( $event instanceof AfterInputChangeEvent ) {
                $this->trigger(new InstanceChangeEvent($this));
            }

            $this->getForm()->trigger($event);
        }
    }
}