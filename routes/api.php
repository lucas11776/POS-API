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
    Route::post('register', 'AuthController@Register')
        ->middleware(['isGuest']);
    Route::post('login', 'AuthController@Login')
        ->middleware(['isGuest']);
    Route::post('logout', 'AuthController@Logout')
        ->middleware(['isUser']);
});

Route::prefix('user')->namespace('user')->group(function () {
    Route::middleware(['isUser'])->group(function () {
        Route::get('', 'UserController@Index');
        Route::match(['PATCH', 'UPDATE'], '', 'UserController@Update');
        Route::match(['PATCH', 'UPDATE'], 'description', 'UserController@UpdateDescription');
        Route::match(['PATCH', 'UPDATE'], 'address', 'UserController@UpdateAddress');
    });
    Route::middleware(['isGuest'])->group(function () {
        Route::prefix('forgot')->group(function () {
            Route::post('password', 'ForgotPasswordController@Index');
        });
    });
});

Route::prefix('users')->namespace('users')->middleware(['isUser'])->group(function () {
    Route::prefix('{user}')->group(function() {
        Route::prefix('role')->group(function() {
            Route::post('', 'RoleController@Add')
                ->middleware(['isAdministrator']);
            Route::delete('', 'RoleController@Remove')
                ->middleware(['isAdministrator']);
        });
    });
});

Route::prefix('products')->namespace('products')->group(function () {
    Route::get('all', 'ProductsController@All');
    Route::get('', 'ProductsController@Index');
    Route::post('', 'ProductController@Create')
        ->middleware(['isUser', 'isAdministrator']);
    Route::prefix('{product}')->group(function () {
        Route::match(['UPDATE','PATCH'], '', 'ProductController@Update')
            ->middleware(['isUser', 'isAdministrator']);
        Route::delete('', 'ProductController@Delete')
            ->middleware(['isUser', 'isAdministrator']);
    });
    Route::prefix('categories')->group(function () {
        Route::get('', 'CategoryController@Index');
        Route::post('', 'CategoryController@Create')
            ->middleware(['isUser', 'isAdministrator']);
        Route::prefix('{productsCategory}')->group(function () {
            Route::match(['PATCH','UPDATE'],'', 'CategoryController@Update')
                ->middleware(['isUser', 'isAdministrator']);
            Route::delete('', 'CategoryController@Delete')
                ->middleware(['isUser', 'isAdministrator']);
        });
    });
});

Route::prefix('services')->namespace('services')->group(function () {
    Route::get('all', 'ServicesController@all');
    Route::get('', 'ServicesController@Index');
    Route::post('', 'ServiceController@Store')
        ->middleware(['isUser','isAdministrator']);
    Route::prefix('{service}')->group(function () {
        Route::match(['UPDATE','PATCH'],'', 'ServiceController@Update')
            ->middleware(['isUser','isAdministrator']);
        Route::delete('', 'ServiceController@Delete')
            ->middleware(['isUser','isAdministrator']);
    });
    Route::prefix('categories')->group(function () {
        Route::post('', 'CategoryController@Create')
            ->middleware(['isUser', 'isAdministrator']);
        Route::prefix('{servicesCategory}')->group(function () {
            Route::match(['UPDATE','PATCH'], '', 'CategoryController@Update')
                ->middleware(['isUser','isAdministrator']);
            Route::delete('', 'CategoryController@Delete')
                ->middleware(['isUser','isAdministrator']);
        });
    });
});
