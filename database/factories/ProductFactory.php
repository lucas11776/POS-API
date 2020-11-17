<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\ProductsCategory;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'category_id' => factory(ProductsCategory::class)->create()->id,
        'name' => $name = $faker->unique()->words(3, true),
        'url' => Str::slug($name),
        'price' => $price = $faker->numberBetween(25, 5000),
        'discount' => rand(0,10) % 2 != 0 ? null : $faker->numberBetween($price / 2, $price),
        'in_stock' => $faker->numberBetween(5, 30),
        'barcode' => $faker->randomNumber(5) . '' . $faker->randomNumber(5),
        'description' => $faker->sentence(500)
    ];
})->afterCreating(Product::class, function (Product $product) {
    $product->image()->create([
        'path' => $path = Storage::url(UploadedFile::fake()
            ->create('picture.png')
            ->storePublicly(\App\Logic\Products\Product::IMAGE_STORAGE)),
        'url' => url($path)
    ]);
    for($i = 0; $i < 3; $i++)
        $product->images()->create([
            'path' => $path = Storage::url(UploadedFile::fake()
                ->create('picture_' . $i . '.png')
                ->storePublicly(\App\Logic\Products\Product::IMAGE_STORAGE)),
            'url' => url($path)
        ]);
});
