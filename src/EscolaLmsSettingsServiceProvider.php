<?php

namespace EscolaLms\Settings;

use Illuminate\Support\ServiceProvider;
use EscolaLms\Settings\Services\Contracts\SettingsServiceContract;
use EscolaLms\Settings\Services\SettingsService;
use EscolaLms\Settings\Repositories\Contracts\SettingsRepositoryContract;
use EscolaLms\Settings\Repositories\SettingsRepository;
use EscolaLms\Settings\AuthServiceProvider;

/**
 * SWAGGER_VERSION
 */

class EscolaLmsSettingsServiceProvider extends ServiceProvider
{
    public $singletons = [
        SettingsRepositoryContract::class => SettingsRepository::class,
        SettingsServiceContract::class => SettingsService::class,
    ];

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register() {
        $this->app->register(AuthServiceProvider::class);
    }
}
