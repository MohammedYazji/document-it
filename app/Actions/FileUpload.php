<?php

namespace App\Actions;

class FileUpload
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handle(string $key, string $path, string $disk = 'public')
    {
        if (request()->hasFile($key)) {
            return request()->file($key)->store($path, $disk);
        }

        return null;
    }
}
