<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'gender' => $faker->randomElement(['male', 'female']),
        'email' => $faker->unique()->email,
        'cellphone_number' => $faker->e164PhoneNumber,
        'description' => $faker->words(300, true),
        'password' => Hash::make(User::DEFAULT_PASSWORD),
    ];
})->afterCreating(User::class, function (User $user) {
    $user->image()->create(['url' => url(User::DEFAULT_PROFILE_PICTURE)]);
});
