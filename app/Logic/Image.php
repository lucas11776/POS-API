<?php


namespace App\Logic;

use App\Image as Model;
use App\Logic\Interfaces\ImageInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;

class Image implements ImageInterface
{
    public function createImage(MorphOne $image, string $path): Model
    {
        return $image->create([
            'path' => $this->fileExistsInStorage($path) ? $path : null,
            'url' => url($path)
        ]);
    }

    public function updateImage(Model $image, string $path): Model
    {
        $image->path = $path;
        $image->url = url($path);
        $image->save();
        return $image;
    }

    public function createImages(MorphMany $images, array $paths): Collection
    {
        $paths = array_map(function (string $path) {
            return [
                'path' => $this->fileExistsInStorage($path) ? $path : null,
                'url' => url($path)
            ];
        }, $paths);

        return $images->createMany($paths);
    }

    private function fileExistsInStorage(string $path): bool
    {
        return Storage::exists(str_replace('/storage/', '', $path));
    }
}
