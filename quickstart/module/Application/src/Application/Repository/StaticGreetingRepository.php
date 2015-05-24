<?php

namespace Application\Repository;

class StaticGreetingRepository implements GreetingRepositoryInterface
{
    protected $availableGreetings = array('Hi', 'Hello', 'Hey', 'What\'s up');

    /**
     * {@inheritDoc}
     */
    public function getRandomGreeting()
    {
        return $this->availableGreetings[array_rand($this->availableGreetings)];
    }
}