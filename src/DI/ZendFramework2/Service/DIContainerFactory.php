<?php
/**
 * PHP-DI
 *
 * @link http://mnapoli.github.io/PHP-DI/
 * @copyright Matthieu Napoli (http://mnapoli.fr/)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace DI\ZendFramework2\Service;

use Acclimate\Container\ContainerAcclimator;
use DI\Container;
use DI\ContainerBuilder;
use Doctrine\Common\Cache\Cache;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Abstract factory responsible of trying to build services from the PHP DI container
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @author Martin Fris
 */
final class DIContainerFactory implements FactoryInterface
{

    use ConfigTrait;

    /**
     * @var Container
     */
    private $container;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Container
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($this->container !== null) {
            return $this->container;
        }

        $builder = new ContainerBuilder();
        $config = $this->getConfig($serviceLocator);
        $configFile = $this->getDefinitionsFilePath($config);
        $builder->addDefinitions($configFile);

        $useAnnotations = $this->getUseAnnotations($config);
        $builder->useAnnotations($useAnnotations);

        $acclimator = new ContainerAcclimator();
        $zfContainer = $acclimator->acclimate($serviceLocator);
        $builder->wrapContainer($zfContainer);

        /**
         * @var $cache Cache
         */
        $cache = $serviceLocator->get('DiCache');

        if ($cache) {
            $builder->setDefinitionCache($cache);
        }

        $this->container = $builder->build();

        return $this->container;
    }

    /**
     * return definitions file path
     *
     * @param array $config
     *
     * @return string
     * @throws
     */
    private function getDefinitionsFilePath(array $config)
    {
        $filePath = __DIR__ . '/../../../../../../../config/php-di.config.php';

        if (isset($config['definitionsFile'])) {
            $filePath = $config['definitionsFile'];
        }

        if (!file_exists($filePath)) {
            throw new \Exception('DI definitions file missing.');
        }

        return $filePath;
    }

    /**
     * returns true, if annotations should be used
     *
     * @param array $config
     * @return bool
     */
    private function getUseAnnotations(array $config)
    {
        if (!isset($config['useAnntotations']) || $config['useAnntotations'] !== true) {
            return false;
        }

        return true;
    }
}
