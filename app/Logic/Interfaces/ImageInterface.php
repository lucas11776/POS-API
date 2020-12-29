<?php

namespace App\Logic\Interfaces;

use App\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface ImageInterface
{
    /**
     * Create entity image from relationship.
     *
     * @param MorphOne $image
     * @param string $path
     * @return Image
     */
    public function createImage(MorphOne $image, string $path): Image;

    /**
     * Upload image path.
     *
     * @param Image $image
     * @param string $path
     * @return Image
     */
    public function updateImage(Image $image, string $path): Image;

    /**
     * Create multiple image entity from relationship.
     *
     * @param MorphMany $images
     * @param array $paths
     * @return Collection
     */
    public function createImages(MorphMany $images, array $paths): Collection;
}
