<?php

use EscolaLms\Settings\Http\Controllers\SettingsController;
use EscolaLms\Settings\Http\Controllers\Admin\SettingsController as AdminSettingsController;


use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/settings'], function () {
    Route::get('/', [SettingsController::class, "index"]);
    Route::get('/{group}/{key}', [SettingsController::class, "show"]);
});

Route::group(['middleware' => ['auth:api'], 'prefix' => 'api/admin'], function () {
    Route::get('settings/groups', [AdminSettingsController::class, 'groups']);
    Route::resource('settings', AdminSettingsController::class);    
});
