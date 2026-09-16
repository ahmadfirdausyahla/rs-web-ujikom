<?php

namespace App;

use Illuminate\Support\Facedes\Storage;
use Illuminate\Http\UploadFile;

trait ImageUploadTraits
{
    public function uploadImage(UploadedFile $file, string $folder = 'images'): string
    {
        return $file->store($folder, 'public');
    }

    public function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)){
            Storage::disk('public')->delete($path);
        }
    }
}