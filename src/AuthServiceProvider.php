<?php

namespace EscolaLms\Settings;

use EscolaLms\Settings\Policies\SettingsPolicy;
use EscolaLms\Settings\Models\Setting;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Setting::class => SettingsPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
