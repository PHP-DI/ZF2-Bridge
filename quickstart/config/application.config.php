<?php
return array(
    'modules' => array(
        'DI\ZendFramework2',
        'ZendDeveloperTools',
        'Application',
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
    'service_manager' => array(
        // ...
        'factories' => array(
            'DI\Container' => 'DI\ZendFramework2\\Service\\DIContainerFactory',
        ),
    ),
);
