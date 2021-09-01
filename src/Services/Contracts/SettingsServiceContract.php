<?php

namespace EscolaLms\Settings\Services\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface SettingsServiceContract
{
    public function publicList(): Collection;

    public function allList(): Collection;

    public function find(string $group, string $key, $public = null): Model;
   
}
