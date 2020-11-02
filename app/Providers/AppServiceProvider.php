<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('words', function ($attribute, $value, $parameters, $validator) {
            $numberCharacters = count(explode(' ', strip_tags($value)));
            return isset($parameters[0]) && is_numeric($parameters[0]) && $numberCharacters < $parameters[0];
        });
    }
}
