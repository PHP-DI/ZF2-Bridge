<?php

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace DI\ZendFramework2\Service\CacheFactory;

use Doctrine\Common\Cache\MemcachedCache;
use Memcached;

/**
 * Class RedisFactory
 * @author mfris
 * @package DI\ZendFramework\Service\CacheFactory
 */
final class MemcachedFactory implements CacheFactoryInterface
{

    /**
     * @param array $config
     * @return MemcachedCache
     */
    public function newInstance(array $config)
    {
        $host = 'localhost';
        $port = 11211;

        if (isset($config['host'])) {
            $host = $config['host'];
        }

        if (isset($config['port'])) {
            $port = $config['port'];
        }

        $cache = new MemcachedCache();
        $memcache = new Memcached;
        $memcache->addServer($host, $port);
        $cache->setMemcached($memcache);

        return $cache;
    }
}
