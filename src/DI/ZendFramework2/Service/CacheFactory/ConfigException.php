<?php
/**
 * @author  mfris
 */
namespace DI\ZendFramework2\Service\CacheFactory;

use Exception;

/**
 * Class ConfigException - custom exception for configuration problems
 *
 * @author mfris
 * @package DI\ZendFramework\Service
 */
class ConfigException extends Exception
{

    /**
     * thrown when adapter is missing in the cache configuration
     *
     * @return ConfigException
     */
    public static function newCacheAdapterMissingException()
    {
        return new self('Cache configuration - adapter missing.');
    }

    /**
     * thrown when an unsupported cache adapter is missing in the cache configuration
     *
     * @param string $adapter
     * @return ConfigException
     */
    public static function newUnsupportedCacheAdapterException($adapter)
    {
        return new self('Unsupported cache adapter - ' . $adapter);
    }
}
