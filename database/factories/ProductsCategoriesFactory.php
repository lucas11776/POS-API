<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductsCategory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ProductsCategory::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->name,
        'url' => Str::slug($name)
    ];
});
