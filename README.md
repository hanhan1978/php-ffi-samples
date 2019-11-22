# PHP-FFI samples
[![CircleCI](https://circleci.com/gh/hanhan1978/php-ffi-samples.svg?style=svg)](https://circleci.com/gh/hanhan1978/php-ffi-samples)

## Requirements

- PHP 7.4 with FFI enabled
- go 1.3 or higher
- gcc

## how to check

checkout this repository

```
$ make
$ composer install
$ ./vendor/bin/phpunit
```


## PHP-FFI with C

- `src/lib/sample.c`
- `src/ArgumentsampleC`

## PHP-FFI with Go

Basically, use c code as interface to prevent seg fault.

- `src/lib/go-sample.c`
- `src/ArgumentsampleGo`

