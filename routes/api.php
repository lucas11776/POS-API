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

Route::prefix('auth')->namespace('authentication')->group(function () {
    Route::post('register', 'AuthController@Register')->middleware(['isGuest']);
    Route::post('login', 'AuthController@Login')->middleware(['isGuest']);
});

Route::prefix('users')->namespace('users')->middleware(['isUser'])->group(function () {
    Route::prefix('{user}')->group(function() {
        Route::prefix('role')->group(function() {
            Route::post('', 'RoleController@Add')->middleware(['isAdministrator']);
            Route::delete('', 'RoleController@Remove')->middleware(['isAdministrator']);
        });
    });
});

Route::prefix('products')->namespace('products')->group(function () {
    Route::prefix('categories')->group(function () {
        Route::post('', 'CategoryController@Create')->middleware(['isUser', 'isAdministrator']);
        Route::prefix('{productsCategory}')->group(function () {
            Route::match(['PATCH','UPDATE'],'', 'CategoryController@Update')->middleware(['isUser', 'isAdministrator']);
            Route::delete('', 'CategoryController@Delete')->middleware(['isUser', 'isAdministrator']);
        });
    });
});
