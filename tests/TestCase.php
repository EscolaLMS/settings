<?php

namespace EscolaLms\Settings\Tests;


use EscolaLms\Settings\AuthServiceProvider;
use EscolaLms\Settings\Database\Seeders\PermissionTableSeeder;
use EscolaLms\Settings\EscolaLmsSettingsServiceProvider;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\PassportServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends \EscolaLms\Core\Tests\TestCase
{
    use DatabaseTransactions;

    public $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PermissionTableSeeder::class);
    }

    protected function getPackageProviders($app): array
    {
        return [
            ...parent::getPackageProviders($app),
            EscolaLmsSettingsServiceProvider::class,
            PassportServiceProvider::class,
            PermissionServiceProvider::class,
            AuthServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.name', 'Lorem IPSUM');
        parent::getEnvironmentSetUp($app);
    }
}
