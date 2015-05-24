<?php
/**
 * PHP-DI
 *
 * @link http://mnapoli.github.io/PHP-DI/
 * @copyright Matthieu Napoli (http://mnapoli.fr/)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace DI\ZendFramework2\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\Exception\RuntimeException;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Abstract factory responsible of trying to build services from the PHP DI container
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @author Martin Fris
 */
class PHPDIAbstractFactory implements AbstractFactoryInterface
{
    const CONTAINER_NAME = 'DI\\Container';

    /**
     * lazy loaded instance of the PHP DI container
     *
     * @var ContainerInterface
     */
    protected $container = null;

    /**
     * {@inheritDoc}
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if ($requestedName === self::CONTAINER_NAME) {
            return true;
        }

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
        if ($this->container !== null) {
            return $this->container;
        }

        $this->container = $serviceLocator->get(static::CONTAINER_NAME);

        if ($this->container instanceof ContainerInterface) {
            return $this->container;
        }

        throw new RuntimeException(sprintf(
            'Container "%s" is not a valid DI\\ContainerInterface, "%s" found',
            'DI\\Container',
            is_object($this->container) ? get_class($this->container) : gettype($this->container)
        ));
    }
}
