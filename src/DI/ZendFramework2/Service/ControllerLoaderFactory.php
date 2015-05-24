<?php
/**
 * PHP-DI
 *
 * @link http://mnapoli.github.io/PHP-DI/
 * @copyright Matthieu Napoli (http://mnapoli.fr/)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace DI\ZendFramework2\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Factory responsible for creating the serviceManager responsible for creating controllers
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 * @see Zend\Mvc\Service\ControllerLoaderFactory
 */
class ControllerLoaderFactory implements FactoryInterface
{
    /**
     * Create the controller loader service
     *
     * Creates and returns an instance of Controller\ControllerManager. The
     * only controllers this manager will allow are those defined in the
     * application configuration's "controllers" array. If a controller is
     * matched, the scoped manager will attempt to load the controller.
     * Finally, it will attempt to inject the controller plugin manager
     * if the controller implements a setPluginManager() method.
     *
     * This plugin manager is _not_ peered against DI, and as such, will
     * not load unknown classes.
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ControllerManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \DI\Container $container */
        $container = $serviceLocator->get('DI\\Container');
        $controllerLoader = new ControllerManager($container);
        $controllerLoader->setServiceLocator($serviceLocator);
        /* @var ServiceManager $serviceLocator */
        $controllerLoader->addPeeringServiceManager($serviceLocator);

        return $controllerLoader;
    }
}
