<?php
/**
 * @author     mfris
 */

namespace DI\ZendFramework2\Service;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\FilesystemCache;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

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

            default:
               throw new \Exception('Unsupported cache adapter - ' . $adapter);
        }
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
}
