<?php

namespace App\Services\Tools;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class ThumbService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->disk = Config::get('filesystems.default');
    }

    public function createQuadThumb(string $image, int $width): string
    {
        $thumbnailPath = str_replace(basename($image), '', $image).'thumbnails/'.basename($image);
        $manager = new ImageManager(new Driver());
        $imageData = Storage::disk($this->disk)->get($image);
        $img = $manager->read($imageData);
        $img->cover($width, $width);
        $imageData = $img->encode();
        Storage::disk($this->disk)->put(
            $thumbnailPath,
            $imageData
        );
        return $thumbnailPath;
    }
}
