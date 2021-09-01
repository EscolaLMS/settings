<?php

namespace EscolaLms\Settings;

use EscolaLms\Settings\Services\Contracts\SettingsServiceContract;
use EscolaLms\Settings\Services\SettingsService;

use Illuminate\Support\ServiceProvider;

/**
 * SWAGGER_VERSION
 */


class EscolaLmsSettingsServiceProvider extends ServiceProvider
{
    public $singletons = [
        SettingsServiceContract::class => SettingsService::class,
    ];

    public function boot()
    {

        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
