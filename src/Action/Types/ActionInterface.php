<?php
namespace Debuqer\Tika\Action\Types;

use Debuqer\Tika\DataStructure\Contracts\ConfigContainerInterface;
use Debuqer\Tika\DataStructure\DataContainers\ActionDataContainer;
use Debuqer\Tika\Form;

interface ActionInterface
{
    /**
     * BaseAction constructor.
     * @param $name
     * @param ActionDataContainer $config
     */
    public function __construct($name,
                                ActionDataContainer $config
    );
    public function run(Form &$form);


    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getEvent();

    /**
     * @return ConfigContainerInterface
     */
    public function getConditions();

    /**
     * @return ConfigContainerInterface
     */
    public function getParameters();

    public function isRunnable(Form &$form);

    /**
     * @return bool
     */
    public function validate();
}