<?php
/**
 * PHP-DI
 *
 * @link http://mnapoli.github.io/PHP-DI/
 * @copyright Matthieu Napoli (http://mnapoli.fr/)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace DI\ZendFramework2;

use Zend\Console\Adapter\AdapterInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;

/**
 * Module that provides PHP-DI integration with ZF2
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
class Module implements ConfigProviderInterface, ConsoleUsageProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../../config/module.config.php';
    }

    /**
     * shows the console banner with clear def. cache command
     *
     * @param \Zend\Console\Adapter\AdapterInterface $console
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getConsoleUsage(AdapterInterface $console)
    {
        return [
            'php-di-clear-cache' => 'Clear PHP DI definitions cache.',
        ];
    }
}
