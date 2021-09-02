<?php

namespace EscolaLms\Settings\Tests;

use EscolaLms\Settings\Tests\TestCase;
use EscolaLms\Settings\Repositories\Contracts\SettingsRepositoryContract;
use EscolaLms\Settings\Models\Setting;
use EscolaLms\Settings\Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Storage;

class RepositoryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_search_repository()
    {
        $this->seed(DatabaseSeeder::class);

        $repository = app()->make(SettingsRepositoryContract::class);
        $settings = $repository->allQuery(['group' => 'currencies'])->get();
        $this->assertGreaterThan(0, $settings->count());
    }

    public function test_model_cast()
    {

        $this->seed(DatabaseSeeder::class);
        $setting = Setting::first();

        $setting->update([
            'type' => 'file',
            'value' => 'format_c',
        ]);


        $this->assertEquals($setting->data, Storage::url('format_c'));

        $arr = ['a', 'b', 'c'];

        $setting->update([
            'type' => 'json',
            'value' => json_encode($arr),
        ]);

        $this->assertEquals($setting->data, $arr);
    }
}
