<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ServicesCategory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ServicesCategory::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->name,
        'url' => Str::slug($name)
    ];
});
