<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ApiDocController extends Controller
{
    public function index()
    {
        Artisan::call("scramble:export");
        $path = public_path('api.json');
        $jsonContent = File::get($path);
        $data = json_decode($jsonContent, true);
        if (isset($data['openapi'])) {
            $data['openapi'] = '3.0.0';
        }
        $updatedJsonContent = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        File::put($path, $updatedJsonContent);
        return view("docs.stoplight");
    }
}
