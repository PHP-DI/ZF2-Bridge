<?php
/**
 * PHP-DI
 *
 * @link http://mnapoli.github.io/PHP-DI/
 * @copyright Matthieu Napoli (http://mnapoli.fr/)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace DI\ZendFramework2\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DI\ContainerBuilder;
use Doctrine\Common\Cache\RedisCache;
use Redis;

/**
 * Abstract factory responsible of trying to build services from the PHP DI container
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @author Martin Fris
 */
class DIContainerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $builder = new ContainerBuilder();
        $configFile = __DIR__ . '/../../../../../../../config/php-di.config.php';

        if (file_exists($configFile)) {
            $builder->addDefinitions($configFile);
        }

//        $redis = new Redis();
//        $redis->connect("localhost");
//        $cache = new RedisCache();
//        $cache->setRedis($redis);
//        $builder->setDefinitionCache($cache);

        return $builder->build();
    }
}
