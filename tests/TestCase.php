<?php

namespace EscolaLms\Fields\Tests;

use EscolaLms\Core\EscolaLmsServiceProvider;
use EscolaLms\Core\Models\User;
use EscolaLms\Fields\AuthServiceProvider;
use EscolaLms\Fields\Database\Seeders\PermissionTableSeeder;
use EscolaLms\Fields\EscolaLmsFieldsServiceProvider;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
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
            EscolaLmsFieldsServiceProvider::class,
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
