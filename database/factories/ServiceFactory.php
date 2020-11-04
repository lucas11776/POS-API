<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Service;
use App\ServicesCategory;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'category_id' => factory(ServicesCategory::class)->create()->id,
        'name' => $name =  $faker->unique()->name,
        'url' => Str::slug($name),
        'price' => $price = $faker->numberBetween(2.5, 3500),
        'discount' => rand(1,10) % 2 == 0 && $price > 25 ? $price / 1.5 : null,
        'description' => $faker->words(250, true)
    ];
})->afterCreating(Service::class, function (Service $service) {
    $service->image()->create([
        'path' => $path = Storage::url(UploadedFile::fake()
            ->create('picture.png')
            ->storePublicly(\App\Logic\Service::IMAGE_STORAGE)),
        'url' => url($path)
    ]);
    for($i = 0; $i < 3; $i++)
        $service->images()->create([
            'path' => $path = Storage::url(UploadedFile::fake()
                ->create('picture_' . $i . '.png')
                ->storePublicly(\App\Logic\Service::IMAGE_STORAGE)),
            'url' => url($path)
        ]);
});
