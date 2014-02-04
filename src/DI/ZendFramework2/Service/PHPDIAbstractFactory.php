<?php
/**
 * PHP-DI
 *
 * @link http://mnapoli.github.io/PHP-DI/
 * @copyright Matthieu Napoli (http://mnapoli.fr/)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace DI\ZendFramework2\Service;


use DI\ContainerInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\Exception\RuntimeException;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Abstract factory responsible of trying to build services from a
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
class PHPDIAbstractFactory implements AbstractFactoryInterface
{
    const CONTAINER_NAME = 'DI\\Container';

    /**
     * {@inheritDoc}
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return $this->getContainer($serviceLocator)->has($requestedName);
    }

    /**
     * {@inheritDoc}
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return $this->getContainer($serviceLocator)->get($requestedName);
    }

    /**
     * @param  ServiceLocatorInterface $serviceLocator
     *
     * @return ContainerInterface
     *
     * @throws \Zend\ServiceManager\Exception\RuntimeException
     */
    protected function getContainer(ServiceLocatorInterface $serviceLocator)
    {
        $container = $serviceLocator->get(static::CONTAINER_NAME);

        if ($container instanceof ContainerInterface) {
            return $container;
        }

        throw new RuntimeException(sprintf(
            'Container "%s" is not a valid DI\\ContainerInterface, "%s" found',
            'DI\\Container',
            is_object($container) ? get_class($container) : gettype($container)
        ));
    }
}
