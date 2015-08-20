<?php
/**
 * @author     mfris
 */

namespace DI\ZendFramework2\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\Common\Cache\FlushableCache;

/**
 * Cotroller for handling of the console commands
 *
 * @author mfris
 * @package \DI\ZendFramework2\Controller
 */
class ConsoleController extends AbstractActionController
{

    /**
     * flushes php di definitions cache
     */
    public function clearCacheAction()
    {
        /* @var $cache FlushableCache */
        $cache = $this->serviceLocator->get('DiCache');

        if ($cache instanceof FlushableCache) {
            $cache->flushAll();
        }

        echo "PHP DI definitions cache was cleared." . PHP_EOL . PHP_EOL;
    }
}