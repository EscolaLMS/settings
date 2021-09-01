<?php

namespace EscolaLms\Fields;

use EscolaLms\Fields\Policies\FieldsPolicy;
use EscolaLms\Fields\Models\Setting;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Setting::class => FieldsPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
