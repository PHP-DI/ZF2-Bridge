<?php
/**
 * @author     mfris
 */

namespace DI\ZendFramework2\Service;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Cache\RedisCache;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Redis;

/**
 * Factory for php di definitions cache
 *
 * @author  mfris
 * @package \DI\ZendFramework2\Service\Cache
 */
class CacheFactory implements FactoryInterface
{

    use ConfigTrait;

    /**
     * returns cache adapter, if configured
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return Cache|null
     * @throws
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $this->getConfig($serviceLocator);

        if (!isset($config['cache'])) {
            return null;
        }

        $config = $config['cache'];

        if (!isset($config['adapter'])) {
            return null;
        }

        $adapter = $config['adapter'];

        switch ($adapter) {
            case 'filesystem':
                return $this->getFilesystemCache($config);

            case 'redis':
                return $this->getRedisCache($config);
        }

        throw new \Exception('Unsupported cache adapter - ' . $adapter);
    }

    /**
     * creates file system cache
     *
     * @param array $config
     *
     * @return FilesystemCache
     */
    private function getFilesystemCache(array $config)
    {
        $directory = getcwd() . '/data/php-di/cache';

        if (isset($config['directory'])) {
            $directory = $config['directory'];
        }

        return new FilesystemCache($directory);
    }

    /**
     * creates redis cache
     *
     * @param array $config
     * @return RedisCache
     */
    private function getRedisCache(array $config)
    {
        $host = 'localhost';
        $port = 6379;

        if (isset($config['host'])) {
            $host = $config['host'];
        }

        if (isset($config['port'])) {
            $port = $config['port'];
        }

        $redis = new Redis();
        $redis->connect($host, $port);

        $cache = new RedisCache();
        $cache->setRedis($redis);

        return $cache;
    }
}
