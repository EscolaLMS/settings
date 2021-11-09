<?php

namespace Tests\Feature;

use Illuminate\Validation\ValidationException;
use EscolaLms\Settings\Facades\AdministrableConfig;
use EscolaLms\Settings\Models\Config as ModelsConfig;
use EscolaLms\Settings\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class ConfigServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_register_and_update_config()
    {
        Config::set('test_config_file.test_key', 'test_value');
        Config::set('test_config_file.test_key2', 'test_value');

        AdministrableConfig::registerConfig('test_config_file.test_key', ['required', 'string'], false, true);
        AdministrableConfig::registerConfig('test_config_file.test_key2', ['required', 'string'], true, false);
        AdministrableConfig::setConfig([
            'test_config_file.test_key' => 'foobar',
            'test_config_file.test_key2' => 'foobar'
        ]);

        $config = AdministrableConfig::getConfig();
        $this->assertEquals('test_value', $config['test_config_file.test_key']['value']);
        $this->assertEquals(false, $config['test_config_file.test_key']['public']);
        $this->assertEquals(true, $config['test_config_file.test_key']['readonly']);
        $this->assertEquals('foobar', $config['test_config_file.test_key2']['value']);
        $this->assertEquals(true, $config['test_config_file.test_key2']['public']);
        $this->assertEquals(false, $config['test_config_file.test_key2']['readonly']);

        $publicConfig = AdministrableConfig::getPublicConfig();
        $this->assertEquals('foobar', $publicConfig['test_config_file.test_key2']);
        $this->assertArrayNotHasKey('test_config_file.test_key', $publicConfig);

        try {
            AdministrableConfig::setConfig([
                'test_config_file.test_key2' => false
            ]);
        } catch (ValidationException $ex) {
            // Before Validator is executed keys have dots '.' replaced with __ because '.' is restricted character for array validation rules
            $this->assertArrayHasKey('test_config_file__test_key2', $ex->errors());
        }
    }

    public function test_store_to_files()
    {
        Config::set('escola_settings.use_database', false);

        Config::set('test_config_file.test_key', 'test_value');
        Config::set('test_config_file.test_key2', 'test_value');

        AdministrableConfig::registerConfig('test_config_file.test_key', ['required', 'string'], false, true);
        AdministrableConfig::registerConfig('test_config_file.test_key2', ['required', 'string'], false);
        AdministrableConfig::setConfig([
            'test_config_file.test_key' => 'foobar',
            'test_config_file.test_key2' => 'foobar'
        ]);
        AdministrableConfig::storeConfig();

        $path = App::configPath('test_config_file.php');
        $this->assertTrue(file_exists($path));

        $file_content = file_get_contents($path);
        $vars = eval('?>' . $file_content);
        $this->assertEquals('test_value', $vars['test_key']);
        $this->assertEquals('foobar', $vars['test_key2']);

        AdministrableConfig::setConfig([
            'test_config_file.test_key' => 'foobar2',
            'test_config_file.test_key2' => 'foobar2'
        ]);
        AdministrableConfig::storeConfig();

        $file_content = file_get_contents($path);
        $vars = eval('?>' . $file_content);
        $this->assertEquals('test_value', $vars['test_key']);
        $this->assertEquals('foobar2', $vars['test_key2']);
    }

    public function test_store_to_database()
    {
        Config::set('escola_settings.use_database', true);

        Config::set('test_config_file.test_key', 'test_value');
        Config::set('test_config_file.test_key2', 'test_value');

        AdministrableConfig::registerConfig('test_config_file.test_key', ['required', 'string'], false, true);
        AdministrableConfig::registerConfig('test_config_file.test_key2', ['required', 'string'], false);
        AdministrableConfig::setConfig([
            'test_config_file.test_key' => 'foobar',
            'test_config_file.test_key2' => 'foobar'
        ]);
        AdministrableConfig::storeConfig();

        $model = ModelsConfig::find(1);
        $this->assertNotNull($model);
        $this->assertEquals('foobar', $model->value['test_config_file.test_key2']);
        $this->assertArrayNotHasKey('test_config_file.test_key', $model->value);
    }

    public function test_load_from_database()
    {
        Config::set('escola_settings.use_database', true);

        Config::set('test_config_file.test_key', 'test_value');
        AdministrableConfig::registerConfig('test_config_file.test_key', ['required', 'string']);

        $config = AdministrableConfig::getPublicConfig();
        $this->assertEquals('test_value', $config['test_config_file.test_key']);
        $this->assertEquals('test_value', Config::get('test_config_file.test_key'));

        $model = ModelsConfig::create(['id' => 1, 'value' => ['test_config_file.test_key' => 'foobar']]);

        $this->assertTrue(AdministrableConfig::loadConfigFromDatabase(true));

        $config = AdministrableConfig::getPublicConfig();
        $this->assertEquals('foobar', $config['test_config_file.test_key']);
        $this->assertEquals('foobar', Config::get('test_config_file.test_key'));
    }

    public function test_load_from_database_fails_if_not_enabled_or_forced()
    {
        Config::set('escola_settings.use_database', false);

        Config::set('test_config_file.test_key', 'test_value');
        AdministrableConfig::registerConfig('test_config_file.test_key', ['required', 'string']);

        $config = AdministrableConfig::getPublicConfig();
        $this->assertEquals('test_value', $config['test_config_file.test_key']);
        $this->assertEquals('test_value', Config::get('test_config_file.test_key'));

        $model = ModelsConfig::create(['id' => 1, 'value' => ['test_config_file.test_key' => 'foobar']]);

        $this->assertFalse(AdministrableConfig::loadConfigFromDatabase());

        $config = AdministrableConfig::getPublicConfig();
        $this->assertEquals('test_value', $config['test_config_file.test_key']);
        $this->assertEquals('test_value', Config::get('test_config_file.test_key'));
    }
}
