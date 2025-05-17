<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;

/**
 * Theme routes.
 *
 * The routes defined inside your theme override any similar routes
 * defined on the application global scope.
 */

Route::group(['middleware' => ['web', 'admin']], function () {
    // La barra inicial detiene cualquier prefijo que quiera meter el tema
    Route::resource('people', '\App\Http\Controllers\PersonController');
});

