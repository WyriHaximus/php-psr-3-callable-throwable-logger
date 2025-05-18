# Callable throwable decorator around a [PSR-3](http://www.php-fig.org/psr/psr-3/) logger (to be used with [`react/promise`](https://reactphp.org/promise/) and [`reactivex/rxphp`](https://github.com/ReactiveX/RxPHP))

[![Continuous Integration](https://github.com/WyriHaximus/php-psr-3-callable-throwable-logger/actions/workflows/ci.yml/badge.svg)](https://github.com/WyriHaximus/php-psr-3-callable-throwable-logger/actions/workflows/ci.yml)
[![Latest Stable Version](https://poser.pugx.org/WyriHaximus/psr-3-callable-throwable-logger/v/stable.png)](https://packagist.org/packages/WyriHaximus/psr-3-callable-throwable-logger)
[![Total Downloads](https://poser.pugx.org/WyriHaximus/psr-3-callable-throwable-logger/downloads.png)](https://packagist.org/packages/WyriHaximus/psr-3-callable-throwable-logger/stats)
[![Code Coverage](https://scrutinizer-ci.com/g/WyriHaximus/php-psr-3-callable-throwable-logger/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/WyriHaximus/php-psr-3-callable-throwable-logger/?branch=master)
[![License](https://poser.pugx.org/WyriHaximus/psr-3-callable-throwable-logger/license.png)](https://packagist.org/packages/wyrihaximus/psr-3-callable-throwable-logger)

### Installation ###

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `^`.

```
composer require wyrihaximus/psr-3-callable-throwable-logger
```

## Usage with [`react/promise`](https://reactphp.org/promise/)

Whenever a promise rejects the closure from `CallableThrowableLogger::create`  will be invoked and an `error` message
will be logged to `$logger`

```php
$logger = new Psr3Logger();
$reactPromise->then(function () {
    // Happy flow handler
}, CallableThrowableLogger::create($logger));
```

## Usage with [`reactivex/rxphp`](https://github.com/ReactiveX/RxPHP)

Whenever an errors comes from the stream the closure from `CallableThrowableLogger::create`  will be invoked and
and `error` message will be logged to `$logger`.

```php
$logger = new Psr3Logger();
$rxPhpStream->subscribute(function ($item) {
    // Items handler
}, CallableThrowableLogger::create($logger), function () {
    // Done
});
```

## Optional arguments

```php
CallableThrowableLogger::create(
    $logger, // required: PSR-3 logger
    'error', // optional: Message level
    'Uncaught Throwable %1$s: "%2$s" at %3$s line %4$s', // optional: Message
    // %1$s => the throwable classname
    // %2$s => the throwable message
    // %3$s => the throwable file
    // %4$s => the throwable line
);
```

## Contributing ##

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License ##

Copyright 2025 [Cees-Jan Kiewiet](http://wyrihaximus.net/)

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
