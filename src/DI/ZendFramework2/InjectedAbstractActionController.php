<?php
namespace DI\ZendFramework2;

use DI\Container;
use DI\Annotation\Inject;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Stdlib\ResponseInterface as Response;

abstract class InjectedAbstractActionController extends AbstractActionController
{
	protected $container;

	public function __construct(Container $container = null)
	{
		$this->container = $container;
	}

	public function dispatch(Request $request, Response $response = null)
	{
		if ($this->container == null)
			$this->container = $this->serviceLocator->get('DI\\Container');

		$this->container->injectOn($this);
		return parent::dispatch($request, $response);
	}
}
