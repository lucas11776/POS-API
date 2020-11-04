<?php

namespace App\Logic;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Upload implements UploadInterface
{
    public function uploads(array $files, string $storage = 'public'): array
    {
        $paths = [];

        foreach ($files as $file)
            $paths[] = $this->upload($file, $storage);

        return $paths;
    }

    public function upload(UploadedFile $file, string $storage = 'public'): string
    {
        $path = $file->storePublicly($storage);

        return Storage::url($path);
    }
}
