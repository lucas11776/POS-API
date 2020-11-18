<?php

namespace App\Logic;

use App\Logic\Interfaces\UploadInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Upload implements UploadInterface
{
    public function uploads(array $files, string $storage = 'public', string $visibility = 'public'): array
    {
        $paths = [];

        foreach ($files as $file)
            $paths[] = $this->upload($file, $storage, $visibility);

        return $paths;
    }

    public function upload(UploadedFile $file, string $storage = 'public', string $visibility = 'public'): string
    {
        $path = $file->store($storage, ['visibility' => $visibility]);

        return Storage::url($path);
    }
}
