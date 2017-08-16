<?php

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace DI\ZendFramework2\Service\CacheFactory;

use Doctrine\Common\Cache\RedisCache;
use Redis;

/**
 * Class RedisFactory
 * @author mfris
 * @package DI\ZendFramework\Service\CacheFactory
 */
final class RedisFactory implements CacheFactoryInterface
{

    /**
     * @param array $config
     * @return RedisCache
     */
    public function newInstance(array $config)
    {
        $host = 'localhost';
        $port = 6379;
        $database = 0;

        if (isset($config['host'])) {
            $host = $config['host'];
        }

        if (isset($config['port'])) {
            $port = $config['port'];
        }

        if (isset($config['database'])) {
            $database = (int) $config['database'];
        }

        $redis = new Redis();
        $redis->connect($host, $port);

        if ($database) {
            $redis->select($database);
        }

        $cache = new RedisCache();
        $cache->setRedis($redis);

        return $cache;
    }
}
