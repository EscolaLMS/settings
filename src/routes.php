<?php

use EscolaLms\Fields\Http\Controllers\FieldsController;

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/settings'], function () {
    Route::get('/', [FieldsController::class, "index"]);
    Route::get('/{group}/{key}', [FieldsController::class, "show"]);
});

