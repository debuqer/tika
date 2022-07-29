<?php


namespace Debuqer\TikaFormBuilder\Event;


abstract class BaseEvent implements EventInterface
{
    /** @var \SplObjectStorage  */
    protected \SplObjectStorage $observers;

    public $caller;

    public function __construct($caller)
    {
        $this->observers = new \SplObjectStorage();

        $this->caller = $caller;
    }

    /**
     * @inheritDoc
     */
    public function attach(\SplObserver $observer)
    {
        $this->observers->attach($observer);
    }

    /**
     * @inheritDoc
     */
    public function detach(\SplObserver $observer)
    {
        $this->observers->detach($observer);
    }

    /**
     * @inheritDoc
     */
    public function notify()
    {
        /** @var \SplObserver $observer */
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}