<?php
/**
 * @author     mfris
 * @copyright  Pixel federation
 * @license    Internal use only
 */

namespace DI\ZendFramework2\Service;

use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * simple trait for getting php di config data from zf2 config array
 * @author  mfris
 * @package DI\ZendFramework2\Service
 */
trait ConfigTrait
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return array
     */
    private function getConfig(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        if (isset($config['phpdi-zf2'])) {
            $config = $config['phpdi-zf2'];
        } else {
            $config = [];
        }

        return $config;
    }
}
