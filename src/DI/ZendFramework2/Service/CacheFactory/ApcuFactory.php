<?php

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace DI\ZendFramework2\Service\CacheFactory;

use Doctrine\Common\Cache\ApcuCache;

/**
 * Class RedisFactory
 * @author mfris
 * @package DI\ZendFramework\Service\CacheFactory
 */
final class ApcuFactory implements CacheFactoryInterface
{

    /**
     * @param array $config
     * @return ApcuCache
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function newInstance(array $config)
    {
        return new ApcuCache();
    }
}
