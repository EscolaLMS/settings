<?php

namespace Tests\APIs;

use EscolaLms\Settings\Database\Seeders\PermissionTableSeeder;
use EscolaLms\Settings\Facades\AdministrableConfig;
use EscolaLms\Settings\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;

class ConfigApiTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PermissionTableSeeder::class);

        $this->user = config('auth.providers.users.model')::factory()->create();
        $this->user->guard_name = 'api';
        $this->user->assignRole('admin');

        Config::set('test_config_file.test_key', 'test_value');
        Config::set('test_config_file.test_key2', 'test_value');

        AdministrableConfig::registerConfig('test_config_file.test_key', ['required', 'string'], false, true);
        AdministrableConfig::registerConfig('test_config_file.test_key2', ['required', 'string'], true, false);
    }

    public function test_get_public()
    {
        $this->response = $this->json(
            'GET',
            '/api/config'
        );
        $this->response->assertOk();
        $this->response->assertJsonFragment([
            'data' => [
                'test_config_file' => ['test_key2' => 'test_value']
            ]
        ]);
        $this->response->assertJsonMissing([
            'data' => [
                'test_config_file' => ['test_key' => 'test_value']
            ]
        ]);
    }

    public function test_get_admin()
    {
        $this->response = $this->actingAs($this->user, 'api')->json(
            'GET',
            '/api/admin/config'
        );
        $this->response->assertOk();
        $this->response->assertJsonFragment([
            'data' => [
                'test_config_file' => [
                    'test_key' => [
                        'key' => 'test_config_file.test_key',
                        'rules' => [
                            'required',
                            'string'
                        ],
                        'value' => 'test_value',
                        'readonly' => true,
                        'public' => false,
                    ],
                    'test_key2' => [
                        'key' => 'test_config_file.test_key2',
                        'rules' => [
                            'required',
                            'string'
                        ],
                        'value' => 'test_value',
                        'readonly' => false,
                        'public' => true,
                    ]
                ]
            ]
        ]);
    }

    public function test_update()
    {
        $this->response = $this->json(
            'GET',
            '/api/config'
        );
        $this->response->assertJsonMissing([
            'test_config_file' => [
                'test_key2' => 'foobar'
            ]
        ]);

        $this->response = $this->actingAs($this->user, 'api')->json(
            'POST',
            '/api/admin/config',
            [
                'config' => [
                    [
                        'key' => 'test_config_file.test_key',
                        'value' => 'foobar'
                    ],
                    [
                        'key' => 'test_config_file.test_key2',
                        'value' => 'foobar'
                    ]
                ]
            ]
        );
        $this->response->assertOk();

        $this->response = $this->json(
            'GET',
            '/api/config'
        );
        $this->response->assertOk();
        $this->response->assertJsonFragment([
            'test_config_file' => [
                'test_key2' => 'foobar',
            ]
        ]);

        $this->response = $this->actingAs($this->user, 'api')->json(
            'GET',
            '/api/admin/config'
        );
        $this->response->assertOk();
        $this->response->assertJsonFragment([
            'data' => [
                'test_config_file' => [
                    'test_key' => [
                        'key' => 'test_config_file.test_key',
                        'rules' => [
                            'required',
                            'string'
                        ],
                        'value' => 'test_value',
                        'readonly' => true,
                        'public' => false,
                    ],
                    'test_key2' => [
                        'key' => 'test_config_file.test_key2',
                        'rules' => [
                            'required',
                            'string'
                        ],
                        'value' => 'foobar',
                        'readonly' => false,
                        'public' => true,
                    ]
                ]
            ]
        ]);
    }
}
