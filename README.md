# PHP-DI integration with Zend Framework 2

This library provides integration for PHP-DI with Zend Framework 2.

[PHP-DI](http://github.com/mnapoli/PHP-DI) is a Dependency Injection Container for PHP.

## Use

Require the libraries with Composer:

    {
        "require": {
            "mnapoli/php-di": "*",
            "mnapoli/php-di-zf2": "*"
        }
    }

To use PHP-DI in your ZF2 application, you need to make the following two changes:

In your application_root/module/Application/config/module.config.php, find the service_manager section
which looks like this:

```php
	'service_manager' => array(
            'abstract_factories' => array(
                'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
                'Zend\Log\LoggerAbstractServiceFactory',
            ),
            'aliases' => array(
                'translator' => 'MvcTranslator',
            ),
        ),
```

Add a factory function to the Zend Service Manager for the PHP-DI container.  The result will look like this:

```php
	'service_manager' => array(
            'abstract_factories' => array(
                'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
                'Zend\Log\LoggerAbstractServiceFactory',
            ),
            'aliases' => array(
                'translator' => 'MvcTranslator',
            ),
			// Begin PHP-DI configuration
		    'factories' => array(
			    'DI\Container' => function () {
				    return new DI\Container();
			    },
		    ),
		    // End PHP-DI configuration
        ),
```

Now in each of your controllers, you must extend DI\ZendFramework2\InjectedAbstractActionController
or DI\ZendFramework2\InjectedAbstractRestfulController, depending on what type of controller it is:

 ```php
	class IndexController extends AbstractActionController
 ```

 becomes

```php
	use DI\ZendFramework2\InjectedAbstractActionController;
	class IndexController extends InjectedAbstractActionController
 ```

 or

 ```php
	class IndexController extends AbstractRestfulController
  ```

  becomes

 ```php
	use DI\ZendFramework2\InjectedAbstractRestfulController;
	class IndexController extends InjectedAbstractRestfulController
  ```

That's it!

Now you can inject dependencies in your controllers!
