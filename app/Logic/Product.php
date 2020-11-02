<?php

namespace App\Logic;

use App\Image;
use App\Product as Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product implements ProductInterface
{
    /**
     * Product image storage.
     *
     * @var string
     */
    public const IMAGE_STORAGE = 'products';

    public function add(array $form): Model
    {
        $product = $this->create($form);
        $imagePath = $this->uploadImage($form['image']);
        $imagesPath = $this->uploadImages($form['images'] ?? []);

        $this->createImage($product, $imagePath);
        $this->createImages($product, $imagesPath);

        // get product with all product relationships
        return $product::where(['id' => $product->id])->firstOrFail();
    }

    public function update(Model $product, array $data): Model
    {
        if(isset($data['name']))
            $data['url'] = Str::slug($data['name']);

        foreach ($data as $key => $value)
            $product->{$key} = $value;

        $product->save();

        return $product;
    }

    public function delete(Model $product): void
    {
        $product->delete();
    }

    protected function create(array $product): Model
    {
        return Model::create([
            'category_id' => isset($product['category_id']) ? $product['category_id'] : null,
            'name' => $product['name'],
            'url' => Str::slug($product['name']),
            'price' => $product['price'],
            'discount' => $product['discount'],
            'in_stock' => isset($product['category_id']) ? $product['category_id'] : null,
            'barcode' => isset($product['in_stock']) ? $product['in_stock'] : null,
            'description' => $product['description']
        ]);
    }

    protected function uploadImage(UploadedFile $image): string
    {
        $path = $image->storePublicly(self::IMAGE_STORAGE);
        return Storage::url($path);
    }

    protected function uploadImages(array $images = []): array
    {
        $array = [];
        foreach ($images as $image)
            $array[] = $this->uploadImage($image);
        return $array;
    }

    protected function createImage(Model $product, string $path): Image
    {
        return $product->image()->create([
            'path' => $path,
            'url' => url($path)
        ]);
    }

    protected function createImages(Model $product, array $images): Collection
    {
        return $product->images()->createMany(array_map(function (string $path) {
            return [
                'path' => $path,
                'url' => url($path)
            ];
        }, $images));
    }
}
