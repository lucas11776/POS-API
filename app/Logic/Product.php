<?php

namespace App\Logic;

use App\Logic\Image as ImageLogic;
use App\Product as Model;
use Illuminate\Support\Str;

class Product implements ProductInterface
{
    /**
     * Product image storage.
     *
     * @var string
     */
    public const IMAGE_STORAGE = 'products';

    /**
     * @var Upload
     */
    public $upload;

    /**
     * @var ImageLogic
     */
    public $image;

    public function __construct(Upload $upload, ImageLogic $image)
    {
        $this->upload = $upload;
        $this->image = $image;
    }

    public function add(array $form): Model
    {
        $product = $this->create($form);

        $this->createImages($product, $form);

        return Model::query()->find($product)->first();
    }

    public function update(Model $product, array $data): Model
    {
        if(isset($data['name']))
            $data['url'] = Str::slug($data['name']);

        $product->fill($data);
        $product->save();

        return $product;
    }

    public function delete(Model $product): void
    {
        $product->delete();
    }

    protected function create(array $data): Model
    {
        $data['url'] = Str::slug($data['name']);

        $product = (new Model())->fill($data);

        $product->save();

        return $product;
    }

    protected function createImages(Model $product, array $data): void
    {
        $mainImage = $this->upload->upload($data['image'], self::IMAGE_STORAGE);
        $previewImages = $this->upload->uploads($data['images'] ?? [], self::IMAGE_STORAGE);

        $this->image->createImage($product->image(), $mainImage);
        $this->image->createImages($product->images(), $previewImages);
    }
}
