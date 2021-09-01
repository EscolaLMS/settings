<?php

namespace EscolaLms\Fields\Enums;

use EscolaLms\Core\Enums\BasicEnum;

class SettingsPermissionsEnum extends BasicEnum
{
    const SETTINGS_MANAGE = 'settings manage';
    //
    const SETTINGS_CREATE      = 'settings create';
    const SETTINGS_DELETE      = 'settings delete';
    const SETTINGS_UPDATE      = 'settings update';
    const SETTINGS_READ        = 'settings read';
    const SETTINGS_LIST        = 'settings list any';

}