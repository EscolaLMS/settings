# Pages

Setting and fields management package

[![swagger](https://img.shields.io/badge/documentation-swagger-green)](https://escolalms.github.io/settings/)
[![codecov](https://codecov.io/gh/EscolaLMS/settings/branch/main/graph/badge.svg?token=gBzpyNK8DQ)](https://codecov.io/gh/EscolaLMS/settings)
[![phpunit](https://github.com/EscolaLMS/settings/actions/workflows/test.yml/badge.svg)](https://github.com/EscolaLMS/settings/actions/workflows/test.yml)
[![downloads](https://img.shields.io/packagist/dt/escolalms/settings)](https://packagist.org/packages/escolalms/settings)
[![downloads](https://img.shields.io/packagist/v/escolalms/settings)](https://packagist.org/packages/escolalms/settings)
[![downloads](https://img.shields.io/packagist/l/escolalms/settings)](https://packagist.org/packages/escolalms/settings)

See swagger for details

## Administration of Registered Config Keys

This package can be used to enable Admins to change Application config values using API.

Every package can register config keys by calling `registerConfig` static method from `AdministrableConfig` Facade in its own Package Service Provider `register` method.

```php
use EscolaLms\Settings\Facades\AdministrableConfig;

public function register(){

    //...

    AdministrableConfig::registerConfig($key = 'config_file.config_key', $rules = ['required', 'string'], $public = true, $readonly = false);

}

```

When registering a configuration key you can:

-   specify validation rules for values that can be stored
-   specify if key is `public` (so anonymous users can retrieve the value)
-   specify if key is `readonly` (so it is returned by API but can not be changed using API)

## Configuration

Publish config file using `php artisan vendor:publish --tag=escola_settings.config`.
Config file contains `use_database` option, which determines if Config should be written and loaded to database (if `true`), or config files should be overwritten (if `false`);