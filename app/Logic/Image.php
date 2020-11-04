<?php


namespace App\Logic;

use App\Image as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Image implements ImageInterface
{
    public function createImage(MorphOne $image, string $path): Model
    {
        return $image->create([
            'path' => $path,
            'url' => url($path)
        ]);
    }

    public function createImages(MorphMany $images, array $paths): Collection
    {
        $paths = array_map(function (string $path) {
            return [
                'path' => $path,
                'url' => url($path)
            ];
        }, $paths);

        return $images->createMany($paths);
    }
}
