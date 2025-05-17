<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;

/**
 * Application routes.
 */
Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['admin']], function () {
    Route::resource('people', PersonController::class);
});
