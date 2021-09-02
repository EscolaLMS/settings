<?php

use EscolaLms\Settings\Http\Controllers\SettingsController;

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/settings'], function () {
    Route::get('/', [SettingsController::class, "index"]);
    Route::get('/{group}/{key}', [SettingsController::class, "show"]);
});

