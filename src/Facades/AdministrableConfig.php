<?php

namespace EscolaLms\Settings\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool  registerConfig(string $key, array $rules = ['required'], bool $public = true, bool $readonly = false)
 * @method static bool  storeConfig()
 * @method static bool  loadConfigFromDatabase()
 * @method static array getPublicConfig()
 * @method static array getConfig(string $key = null)
 * @method static void  setConfig(array $config)
 *
 * @see \EscolaLms\Settings\Services\AdministrableConfigService
 */
class AdministrableConfig extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'escola_config_facade';
    }
}
