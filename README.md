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

To use PHP-DI in your ZF2 application, you need to edit `application_root/config/module.config.php`:

```php
    // ...
    'modules' => [
        ...
        'DI\ZendFramework2',
        ...
    ],
```

That's it!

Now you dependencies are injected in your controllers!

If you'd like to specify the di configuration yourself, create this file: `application_root/config/php-di.config.php`
and save it with your PHP DI configuration e.g. like this:

```
return [
    'Application\Service\GreetingServiceInterface' => Di\object('Application\Service\GreetingService'),
];
```

Head over to [PHP-DI's documentation](http://php-di.org/doc/) if needed.
