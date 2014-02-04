<?php
/**
 * PHP-DI
 *
 * @link http://mnapoli.github.io/PHP-DI/
 * @copyright Matthieu Napoli (http://mnapoli.fr/)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace DI\ZendFramework2;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Module that provides PHP-DI integration with ZF2
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
class Module implements ConfigProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return array(
            'service_manager' => array(
                'abstract_factories' => array(
                    __NAMESPACE__ . '\\Service\\PHPDIAbstractFactory'
                        => __NAMESPACE__ . '\\Service\\PHPDIAbstractFactory',
                ),
            ),
        );
    }
}
