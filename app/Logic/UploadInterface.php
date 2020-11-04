<?php

namespace App\Logic;

use Illuminate\Http\UploadedFile;

interface UploadInterface
{
    /**
     * Upload multiple files in storage.
     *
     * @param array $files
     * @param string $storage
     * @return array
     */
    public function uploads(array $files, string $storage = 'public'): array;

    /**
     * Upload file in storage.
     *
     * @param UploadedFile $file
     * @param string $storage
     * @return string
     */
    public function upload(UploadedFile $file, string $storage = 'public'): string;
}
