<?php

namespace App\Services\Tools;

class FileUploaderService
{
    private $disk;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->disk = env('FILESYSTEM_DISK', 'public');
    }

    public function upload(string $path, string $filename){

    }

    public function delete(string $path, string $filename){

    }
}
