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
use Zend\ServiceManager\Exception;
use Zend\Mvc\Controller\ControllerManager as ZendControllerManager;
use Zend\ServiceManager\ConfigInterface;
use Zend\Stdlib\DispatchableInterface;

/**
 * Manager for loading controllers
 *
 * Does not define any controllers by default, but does add a validator.
 */
class ControllerManager extends ZendControllerManager
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     * @param ConfigInterface $configuration
     */
    public function __construct(ContainerInterface $container, ConfigInterface $configuration = null)
    {
        $this->container = $container;

        parent::__construct($configuration);
    }

    /**
     * Retrieve a service from the manager by name
     *
     * Allows passing an array of options to use when creating the instance.
     * createFromInvokable() will use these and pass them to the instance
     * constructor if not null and a non-empty array.
     *
     * @param  string $name
     * @param  array  $options
     * @param  bool   $usePeeringServiceManagers
     *
     * @return object
     *
     * @throws Exception\ServiceNotFoundException
     * @throws Exception\ServiceNotCreatedException
     * @throws Exception\RuntimeException
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    public function get($name, $options = array(), $usePeeringServiceManagers = true)
    {
        $controller = null;

        if ($this->container->has($name)) {
            $controller = $this->container->get($name);
        } elseif (parent::has($name, true, $usePeeringServiceManagers)) {
            $controller = parent::get($name, $options, $usePeeringServiceManagers);
        }

        if (!$controller) {
            throw new Exception\ServiceNotFoundException("Unable to locate service '{$name}'");
        } elseif (!($controller instanceof DispatchableInterface)) {
            throw new Exception\RuntimeException("Service '{$name}' is not a Controller.");
        }

        return $controller;
    }

    /**
     * Override: do not use peering service managers
     *
     * @param  string|array $name
     * @param  bool         $checkAbstractFactories
     * @param  bool         $usePeeringServiceManagers
     * @return bool
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    public function has($name, $checkAbstractFactories = true, $usePeeringServiceManagers = false)
    {
        if (is_string($name) && $this->container->has($name)) {
            return true;
        } elseif (parent::has($name, $checkAbstractFactories, $usePeeringServiceManagers)) {
            return true;
        }

        return false;
    }
}
