<?php

namespace EscolaLms\Fields\Services\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface FieldsServiceContract
{
    public function publicList(): Collection;

    public function allList(): Collection;

    public function find(string $group, string $key, $public = null): Model;
   
}
