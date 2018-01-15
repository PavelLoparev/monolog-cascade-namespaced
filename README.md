Monolog Cascade Namespaced [![Build Status](https://travis-ci.org/PavelLoparev/monolog-cascade-namespaced.svg?branch=master)](https://travis-ci.org/PavelLoparev/monolog-cascade-namespaced)
===============

What is Monolog Cascade Namespaced?
------------------------

Monolog Cascade Namespaced is a [Monolog Cascade](https://github.com/theorchard/monolog-cascade) extension that allows you to configure loggers for a specific namespace/class.

------------


Installation
------------

Add `monolog-cascade-namespaced` as a requirement in your `composer.json` file or run:
```sh
$ composer require fluffy/monolog-cascade-namespaced
```

**Note**: Monolog Cascade requires PHP 5.3.9 or higher.

Usage
-----

Load configuration (Monolog cascade [supports](https://github.com/theorchard/monolog-cascade#configuring-your-loggers) the following config formats: `yml`, `json` and `php`):
```php
<?php

use CascadeNamespaced\CascadeNamespaced;

CascadeNamespaced::fileConfig('path/to/some/config.yaml');
```

Then just use your logger:
```php
CascadeNamespaced::getLogger(get_called_class())->info('Info message.');
```

**Note**: You must pass a full class name into `CascadeNamespaced::getLogger()` method in order to have possibility to configure this logger in your configuration file in the future if you want it to have specific configuration. You can get a full class name with a help of `get_called_class()` function.

Configuring
-----------

### Root logger
Define `root` logger in your cascade configuration. It will be returned by `CascadeNamespaced::getLogger(get_called_class())` if there are no any specific loggers defined for your namespace/class. It's default logger for your application. If there is no `root` logger defined then default monolog logger will be returned.
```yaml
handlers:
    console:
        class: Monolog\Handler\StreamHandler
        stream: php://stdout

loggers:
    root:
        handlers: [console]

```

### Namespace/Class specific loggers
Let's say you have next classes:
```
MyNamespace\Class1
MyNamespace\Class2
MyNamespace\SubNamespace\Class3
MyNamespace\SubNamespace\Class4
AnotherNamespace\Class5
```
And you want to log messages from `MyNamespace\SubNamespace` namespace classes into the stdout, but messages from `MyNamespace\Class1` and `MyNamespace\Class2` classes into two different files. It can be done with next configuration:
```
handlers:
    file1:
        class: Monolog\Handler\StreamHandler
        stream: log_file_1.log

    file2:
        class: Monolog\Handler\StreamHandler
        stream: log_file_2.log

    console:
        class: Monolog\Handler\StreamHandler
        stream: php://stdout

loggers:
    # Will be used for `AnotherNamespace\Class5` class as a default logger
    # because there are no specific loggers defined for this class.
    root:
        handlers: [console]

    # Will be used for all the classes from `MyNamespace\SubNamespace` namespace.
    MyNamespace\SubNamespace:
        handlers: [console]

    # Will be used for `MyNamespace\Class1` class.
    MyNamespace\Class1:
        handlers: [file1]

    # Will be used for `MyNamespace\Class2` class.
    MyNamespace\Class2:
        handlers: [file2]

```
For other classes `CascadeNamespaced` will return `root` logger as a default logger for the application.

Tests
-----

```sh
$ composer install
$ ./vendor/bin/phpunit
```

License
-------

Monolog Cascade Namespaced is licensed under the MIT License - see the `LICENSE` file for details.
