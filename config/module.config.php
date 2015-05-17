<?php
/**
 * PHP-DI
 *
 * @link http://mnapoli.github.io/PHP-DI/
 * @copyright Matthieu Napoli (http://mnapoli.fr/)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */
namespace DI\ZendFramework2;

return [
    'service_manager' => [
        'abstract_factories' => array(
            __NAMESPACE__ . '\\Service\\PHPDIAbstractFactory' => __NAMESPACE__ . '\\Service\\PHPDIAbstractFactory',
        ),

        'factories' => [
            'ControllerLoader' => __NAMESPACE__ . '\\Service\\ControllerLoaderFactory',
            'DI\Container' => __NAMESPACE__ . '\\Service\\DIContainerFactory',
        ],
    ],
];