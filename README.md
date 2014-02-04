# PHP-DI integration with Zend Framework 2

This library provides integration for PHP-DI with Zend Framework 2.

[PHP-DI](http://php-di.org/) is a Dependency Injection Container for PHP.

If you are looking for Zend Framework 1 integration, head over [here](https://github.com/mnapoli/PHP-DI-ZF1).

## Use

Require the libraries with Composer:

```json
{
    "require": {
        "mnapoli/php-di": "*",
        "mnapoli/php-di-zf2": "*"
    }
}
```

To use PHP-DI in your ZF2 application, you need to edit `application_root/module/Application/config/module.config.php`:

```php
    // ...
    'modules' => array(
        'DI\ZendFramework2',
    ),
    // ...
    'service_manager' => array(
        // ...
        'factories' => array(
            'DI\Container' => function () {
                $builder = new DI\ContainerBuilder();
                // Configure your container here
                return $builder->build();
            },
        ),
    ),
```

That's it!

Now you dependencies are injected in your controllers!

Head over to [PHP-DI's documentation](http://php-di.org/doc/) if needed.
