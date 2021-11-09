<?php

namespace EscolaLms\Settings\Services;

use EscolaLms\Settings\Models\Config as ModelsConfig;
use EscolaLms\Settings\Services\Contracts\AdministrableConfigServiceContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdministrableConfigService implements AdministrableConfigServiceContract
{
    private array $administrableConfig = [];

    public function registerConfig(string $key, array $rules = [], bool $public = true, bool $readonly = false): bool
    {
        $this->administrableConfig[$key] = [
            'rules' => $rules,
            'public' => $public,
            'readonly' => $readonly,
        ];
        return true;
    }

    public function storeConfig(): bool
    {
        if (Config::get('escola_settings.use_database')) {
            return $this->saveConfigToDatabase();
        }
        return $this->saveConfigToFiles();
    }

    /**
     * This is a naive implementation of saving config files, because it strips all comments and evalues things like env() calls to current value.
     * We probably should create a parser/writer that only overwrites variables which we want it to, and leaves everything else intact, but this has to be enough for now.
     */
    private function saveConfigToFiles(): bool
    {
        $keys = $this->getNotReadonlyKeys();
        $config = $this->mapKeysToConfigValues($keys);

        foreach ($config as $key => $value) {
            Config::write($key, $value);
        }

        return true;
    }

    private function saveConfigToDatabase(): bool
    {
        $keys = $this->getNotReadonlyKeys();
        $config = $this->mapKeysToConfigValues($keys);

        $configModel = ModelsConfig::query()->updateOrCreate(['id' => 1], ['value' => $config]);

        return $configModel->exists;
    }

    public function loadConfigFromDatabase(bool $forced = false): bool
    {
        if (Config::get('escola_settings.use_database', false) || $forced) {
            $configModel = ModelsConfig::query()->find(1);
            if (!is_null($configModel)) {
                $config = $configModel->value;
                foreach ($config as $key => $value) {
                    if (array_key_exists($key, $this->administrableConfig) && !$this->administrableConfig[$key]['readonly']) {
                        Config::set($key, $value);
                    }
                }
                return true;
            }
        }
        return false;
    }

    public function setConfig(array $config): void
    {
        $data = [];
        $rules = [];
        foreach ($config as $key => $value) {
            if (is_numeric($key) && is_array($value) && Arr::has($value, ['key', 'value'])) {
                // $config has structure of [['key' => 'foo', 'value' => 'bar'], ['key' => 'foo2', 'value' => 'bar2']] instead of more straightforward ['foo' => 'bar', 'foo2' => 'bar2']
                $key = $value['key'];
                $value = $value['value'];
            }
            if (array_key_exists($key, $this->administrableConfig) && !$this->administrableConfig[$key]['readonly']) {
                $key_without_dot = str_replace('.', '__', $key);
                $data[$key_without_dot] = $value;
                $rules[$key_without_dot] = $this->administrableConfig[$key]['rules'];
            }
        }
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        foreach ($validator->validated() as $key => $value) {
            $key_with_dot = str_replace('__', '.', $key);
            Config::set($key_with_dot, $value);
        }
    }

    public function getConfig(string $key = null): array
    {
        if (empty($key)) {
            $result = [];
            foreach ($this->administrableConfig as $index => $value) {
                $result[$index] = array_merge($value, ['value' => Config::get($index)]);
            }
            return $result;
        }

        if (!array_key_exists($key, $this->administrableConfig)) {
            return [];
        }

        return array_merge($this->administrableConfig[$key], ['value' => Config::get($key)]);
    }

    public function getPublicConfig(): array
    {
        return $this->mapKeysToConfigValues($this->getPublicKeys());
    }

    private function getPublicKeys(): array
    {
        return array_keys(array_filter($this->administrableConfig, fn ($config) => $config['public']));
    }

    private function getNotReadonlyKeys(): array
    {
        return array_keys(array_filter($this->administrableConfig, fn ($config) => !$config['readonly']));
    }

    private function mapKeysToConfigValues(array $keys): array
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = Config::get($key);
        }
        return $result;
    }

    private function undot(array $dotNotationArray)
    {
        $array = [];
        foreach ($dotNotationArray as $key => $value) {
            Arr::set($array, $key, $value);
        }
        return $array;
    }
}
