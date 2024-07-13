<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Modules\FileManager\FileManagerModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * @tags 😻 Dashboard > 6 > File Manager
 */
class FileManagerController extends Controller
{
    protected $fileManager;

    public function __construct(FileManagerModule $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * List Files
     *
     * Bu servis public/media altındaki dosyaları listler
     */
    public function index(Request $request)
    {
        return [$this->fileManager->index()];
    }

    /**
     * Uplad File
     *
     * Bu servis public/media altındaki dosyaları listler
     */
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'pathname' => 'required|string'
        ]);

        $path = $request->input('pathname');
        $file = $request->file('file');

        $destinationPath = public_path($path);
        $file->move($destinationPath, $file->getClientOriginalName());

        return response()->json(['message' => 'File uploaded successfully']);
    }


    /**
     * Create Folder
     *
     * Bu servis public/media altındaki dosyaları listler
     */
    public function createFolder(Request $request)
    {
        $request->validate([
            'folder_path' => 'required|string'
        ]);

        $path = $request->input('folder_path');
        $directoryPath = public_path($path);

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
            return response()->json(['message' => 'Folder created successfully']);
        }

        return response()->json(['message' => 'Folder already exists'], 400);
    }


    /**
     * Rename Folder or File
     *
     * Bu servis public/media altındaki dosyaları listler
     */
    public function rename(Request $request)
    {
        $request->validate([
            'oldName' => 'required|string',
            'newName' => 'required|string',
        ]);

        $oldName = $request->oldName;
        $newName = $request->newName;

        $newPath = dirname($oldName) . '/' . $newName;

        if (!File::exists(public_path($oldName))) {
            return ['error' => 'File or directory does not exist'];
        }

        if (File::exists($newPath)) {
            return ['error' => 'A file or directory with the new name already exists'];
        }

        File::move($oldName, $newPath);

        return ['message' => 'Renamed successfully'];
    }
}
