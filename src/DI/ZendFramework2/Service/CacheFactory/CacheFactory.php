<?php
/**
 * @author     mfris
 */

namespace DI\ZendFramework2\Service\CacheFactory;

use DI\ZendFramework2\Service\ConfigTrait;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\CacheProvider;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for php di definitions cache
 *
 * @author  mfris
 * @package \DI\ZendFramework\Service\Cache
 */
class CacheFactory implements FactoryInterface
{
    use ConfigTrait;

    /**
     * @var array
     */
    private $adapterClasses = [
        'filesystem' => FileSystemFactory::class,
        'redis' => RedisFactory::class,
        'memcached' => MemcachedFactory::class,
        'apcu' => ApcuFactory::class,
    ];

    /**
     * @var CacheFactoryInterface[]
     */
    private $adapters = [];

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $this->getConfig($serviceLocator);

        if (!isset($config['cache'])) {
            return null;
        }

        $config = $config['cache'];
        /* @var $cache CacheProvider|Cache */
        $cache = null;
        $cacheFactory = $this->getCacheFactory($config);
        $cache = $cacheFactory->newInstance($config);

        if (isset($config['namespace'])) {
            $cache->setNamespace(trim($config['namespace']));
        }

        return $cache;
    }

    /**
     * @param array $config
     * @return CacheFactoryInterface
     * @throws ConfigException
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    private function getCacheFactory(array $config)
    {
        if (!isset($config['adapter'])) {
            throw ConfigException::newCacheAdapterMissingException();
        }

        $adapter = $config['adapter'];

        if (!isset($this->adapterClasses[$adapter])) {
            throw ConfigException::newUnsupportedCacheAdapterException($adapter);
        }

        if (!isset($this->adapters[$adapter])) {
            $this->adapters[$adapter] = new $this->adapterClasses[$adapter]();
        }

        /* @var CacheFactoryInterface $cacheFactory */
        return $this->adapters[$adapter];
    }
}
