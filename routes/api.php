<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->namespace('authentication')->middleware('api')->group(function () {
    Route::post('register', 'AuthController@Register')->middleware(['isGuest']);
    Route::post('login', 'AuthController@Login')->middleware(['isGuest']);
});
