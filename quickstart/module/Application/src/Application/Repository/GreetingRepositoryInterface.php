<?php

namespace Application\Repository;

interface GreetingRepositoryInterface
{
    /**
     * @return string
     */
    public function getRandomGreeting();
}