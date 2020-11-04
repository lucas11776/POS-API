<?php


namespace App\Logic;

use App\Service as Model;
use Illuminate\Support\Str;

class Service implements ServiceInterface
{
    /**
     * @var string
     */
    public const IMAGE_STORAGE = 'services';

    /**
     * @var Upload
     */
    public $upload;

    /**
     * @var Image
     */
    public $image;

    public function __construct(Upload $upload, Image $image)
    {
        $this->upload = $upload;
        $this->image = $image;
    }

    public function add(array $form): Model
    {
        $service = $this->create($form);

        $this->createImages($service, $form);

        return Model::query()->find($service)->first();
    }

    public function update(Model $service, array $data): Model
    {
        if(isset($data['name']))
            $data['url'] = Str::slug($data['name']);

        $service->fill($data);
        $service->save();

        return $service;
    }

    public function delete(Model $service): void
    {
        // TODO: Implement delete() method.
    }

    protected function create($data): Model
    {
        $data['url'] = Str::slug($data['name']);

        $service = (new Model())->fill($data);

        $service->save();

        return $service;
    }

    protected function createImages(Model $service, array $data): void
    {
        $mainImage = $this->upload->upload($data['image'], self::IMAGE_STORAGE);
        $previewImages = $this->upload->uploads($data['images'] ?? [], self::IMAGE_STORAGE);

        $this->image->createImage($service->image(), $mainImage);
        $this->image->createImages($service->images(), $previewImages);
    }
}
