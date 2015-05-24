<?php

namespace Application\Service;

interface GreetingServiceInterface
{
    /**
     * @var string $name
     * @return string
     */
    public function greet($name);
}