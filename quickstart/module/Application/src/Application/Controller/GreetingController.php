<?php

namespace Application\Controller;

use Application\Service\GreetingServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GreetingController extends AbstractActionController
{
    /**
     * @Inject
     * @var GreetingServiceInterface
     */
    protected $greetingService;

    public function helloAction()
    {
        $name = $this->getRequest()->getQuery('name', 'anonymous');

        return new ViewModel(array('greeting' => $this->greetingService->greet($name)));
    }
}