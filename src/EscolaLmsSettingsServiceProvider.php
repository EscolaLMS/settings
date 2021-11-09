<?php

namespace EscolaLms\Settings;

use EscolaLms\Settings\AuthServiceProvider;
use EscolaLms\Settings\Facades\AdministrableConfig;
use EscolaLms\Settings\Repositories\Contracts\SettingsRepositoryContract;
use EscolaLms\Settings\Repositories\SettingsRepository;
use EscolaLms\Settings\Services\AdministrableConfigService;
use EscolaLms\Settings\Services\Contracts\AdministrableConfigServiceContract;
use EscolaLms\Settings\Services\Contracts\SettingsServiceContract;
use EscolaLms\Settings\Services\SettingsService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

/**
 * SWAGGER_VERSION
 */
class EscolaLmsSettingsServiceProvider extends ServiceProvider
{
    public $singletons = [
        SettingsRepositoryContract::class => SettingsRepository::class,
        SettingsServiceContract::class => SettingsService::class,
        AdministrableConfigServiceContract::class => AdministrableConfigService::class,
    ];

    public $bindings = [];

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        if (Config::get('escola_settings.use_database', false)) {
            AdministrableConfig::loadConfigFromDatabase();
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'escola_settings');

        $this->app->register(AuthServiceProvider::class);

        $this->app->bind('escola_config_facade', function () {
            return new AdministrableConfigService();
        });
    }

    protected function bootForConsole(): void
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('escola_settings.php'),
        ], 'escola_settings.config');
    }
}
