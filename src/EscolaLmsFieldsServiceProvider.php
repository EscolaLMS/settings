<?php

namespace EscolaLms\Fields;

use EscolaLms\Fields\Services\Contracts\FieldsServiceContract;
use EscolaLms\Fields\Services\FieldsService;

use Illuminate\Support\ServiceProvider;

/**
 * SWAGGER_VERSION
 */


class EscolaLmsFieldsServiceProvider extends ServiceProvider
{
    public $singletons = [
        FieldsServiceContract::class => FieldsService::class,
    ];

    public function boot()
    {

        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
