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
     * @param string $visibility
     * @return array
     */
    public function uploads(array $files, string $storage = 'public', string $visibility = 'public'): array;

    /**
     * Upload file in storage.
     *
     * @param UploadedFile $file
     * @param string $storage
     * @param string $visibility
     * @return string
     */
    public function upload(UploadedFile $file, string $storage = 'public', string $visibility = 'public'): string;
}
