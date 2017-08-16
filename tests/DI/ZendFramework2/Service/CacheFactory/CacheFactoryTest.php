<?php
/**
 * @author  mfris
 */

namespace Test\DI\ZendFramework2\Service;

use DI\ZendFramework2\Service\CacheFactory\CacheFactory;
use DI\ZendFramework2\Service\CacheFactory\ConfigException;
use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Cache\RedisCache;
use Zend\ServiceManager\ServiceManager;

/**
 * Class CacheFactoryTest
 * @author mfris
 * @package Test\DI\ZendFramework2\Service
 */
class CacheFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ServiceManager
     */
    private $serviceManager;

    /**
     * @var CacheFactory
     */
    private $cacheFactory;

    public function setUp()
    {
        $this->serviceManager = new ServiceManager();
        $this->cacheFactory = new CacheFactory();
    }

    public function testCreateRedisCache()
    {
        $this->serviceManager->setService('config', [
            'phpdi-zf2' => [
                'cache' => [
                    'namespace' => 'quickstart',
                    // redis adapter
                    'adapter' => 'redis',
                    'host' => 'localhost',
                    'port' => 6379,
                ],
            ],
        ]);

        $redisCache = $this->cacheFactory->createService($this->serviceManager);
        self::assertInstanceOf(RedisCache::class, $redisCache);
    }

    public function testFileSystemCache()
    {
        $this->serviceManager->setService('config', [
            'phpdi-zf2' => [
                'cache' => [
                    'namespace' => 'quickstart',
                    'adapter' => 'filesystem',
                ],
            ],
        ]);

        $fileSystemCache = $this->cacheFactory->createService($this->serviceManager);
        self::assertInstanceOf(FilesystemCache::class, $fileSystemCache);
    }

    public function testApcuCache()
    {
        $this->serviceManager->setService('config', [
            'phpdi-zf2' => [
                'cache' => [
                    'namespace' => 'quickstart',
                    'adapter' => 'apcu',
                ],
            ],
        ]);

        $apcuCache = $this->cacheFactory->createService($this->serviceManager);
        self::assertInstanceOf(ApcCache::class, $apcuCache);
    }

    public function testInvalidCacheConfigWithoutAdapter()
    {
        $this->serviceManager->setService('config', [
            'phpdi-zf2' => [
                'cache' => [
                ],
            ],
        ]);

        $this->setExpectedException(ConfigException::class, 'Cache configuration - adapter missing.');
        $this->cacheFactory->createService($this->serviceManager);
    }

    public function testInvalidCacheConfigNonExistentAdapter()
    {
        $this->serviceManager->setService('config', [
            'phpdi-zf2' => [
                'cache' => [
                    'adapter' => 'non-existent',
                ],
            ],
        ]);

        $this->setExpectedExceptionRegExp(ConfigException::class, '/^Unsupported cache adapter - /');
        $this->cacheFactory->createService($this->serviceManager);
    }
}
