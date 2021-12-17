<?php

namespace EscolaLms\Settings\Events;

use Illuminate\Contracts\Auth\Authenticatable;

class EscolaLmsSettingPackageConfigUpdatedTemplateEvent
{
    private Authenticatable $user;

    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
    }

    public function getUser(): Authenticatable
    {
        return $this->user;
    }
}
