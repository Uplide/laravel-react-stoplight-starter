<?php

namespace App\Modules\FileManager;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class FileManagerModule
{
    protected $root = "media";

    public function index()
    {
        $directory = public_path($this->root);
        return $this->scanDirectory($directory);
    }

    public function getFile($path)
    {
        $path = public_path('media/' . $path);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    private function scanDirectory($directory)
    {
        $items = [];
        $directories = File::directories($directory);
        $files = File::files($directory);

        foreach ($directories as $dir) {
            $items[] = $this->getDirectoryDetails($dir);
        }

        foreach ($files as $file) {
            $items[] = $this->getFileDetails($file, $directory);
        }

        return [
            'name' => basename($directory),
            'isDirectory' => true,
            'items' => $items,
            'size' => 0,
            'url' => ''
        ];
    }

    private function getDirectoryDetails($directory)
    {
        $items = [];
        $subDirectories = File::directories($directory);
        $files = File::files($directory);

        foreach ($subDirectories as $subDirectory) {
            $items[] = $this->getDirectoryDetails($subDirectory);
        }

        foreach ($files as $file) {
            $items[] = $this->getFileDetails($file, $directory);
        }

        return [
            'name' => basename($directory),
            'isDirectory' => true,
            'items' => $items,
            'size' => 0,
            'url' => '',

        ];
    }

    private function getFileDetails($file, $directory)
    {
        $folder = explode("/" . $this->root . "/", $directory);
        $path = $this->root . "/" . @$folder[1] . "/" . $file->getRelativePathname();
        return [
            'name' => $file->getFilename(),
            'isDirectory' => false,
            'size' => $file->getSize(),
            'url' => env("APP_URL") . "/" . $path,
            "path" => $path
        ];
    }
}
