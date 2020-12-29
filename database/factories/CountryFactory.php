<?php

/** @var Factory $factory */

use App\Country;
use App\Logic\Countries;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Country::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(Countries::countries())['name']
    ];
});
