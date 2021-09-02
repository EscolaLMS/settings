<?php

namespace EscolaLms\Settings\Services;

use Illuminate\Support\Collection;
use EscolaLms\Settings\Services\Contracts\SettingsServiceContract;
use EscolaLms\Settings\Models\Setting;
use Illuminate\Database\Eloquent\Model;

class SettingsService implements SettingsServiceContract
{
    public function publicList(): Collection
    {
        return Setting::where([
            ['public', true],
            ['enumerable', true]
        ])->orderBy('sort')->get();
    }

    public function allList(): Collection
    {
        return Setting::orderBy('group')
            ->orderBy('key')
            ->orderBy('sort')
            ->get();
    }

    public function find(string $group, string $key, $public = null): Model
    {
        $where = [
            ['group', $group],
            ['key', $key]
        ];
        if (isset($public)) {
            $where[] = ['public', $public];
        }
        return Setting::where($where)->firstOrFail();
    }
}
