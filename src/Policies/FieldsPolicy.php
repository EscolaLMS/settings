<?php

namespace EscolaLms\Fields\Policies;

use EscolaLms\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use EscolaLms\Fields\Enums\SettingsPermissionsEnum;

class FieldsPolicy
{

    use HandlesAuthorization;

    public function list(User $user): bool
    {
        return $user->can(SettingsPermissionsEnum::SETTINGS_LIST);
    }

    public function view(User $user): bool
    {
        return $user->can(SettingsPermissionsEnum::SETTINGS_READ);
    }

    public function create(User $user): bool
    {
        return $user->can(SettingsPermissionsEnum::SETTINGS_CREATE);
    }

    public function update(User $user): bool
    {
        return $user->can(SettingsPermissionsEnum::SETTINGS_UPDATE);
    }

    public function delete(User $user): bool
    {
        return $user->can(SettingsPermissionsEnum::SETTINGS_DELETE);
    }
}
