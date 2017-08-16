<?php

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace DI\ZendFramework2\Service\CacheFactory;

use Doctrine\Common\Cache\FilesystemCache;

/**
 * Class FileSystemFactory
 * @author mfris
 * @package DI\ZendFramework\Service\CacheFactory
 */
final class FileSystemFactory implements CacheFactoryInterface
{

    /**
     * @param array $config
     * @return FilesystemCache
     * @throws \InvalidArgumentException
     */
    public function newInstance(array $config)
    {
        $directory = getcwd() . '/data/php-di/cache';

        if (isset($config['directory'])) {
            $directory = $config['directory'];
        }

        return new FilesystemCache($directory);
    }
}
