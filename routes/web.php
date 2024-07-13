<?php

use App\Http\Controllers\Common\ApiDocController;
use App\Modules\FileManager\FileManagerModule;
use Illuminate\Support\Facades\Route;

if (env("APP_ENV") !== "production") {
    Route::get("/api/doc", [ApiDocController::class, "index"]);
}

Route::get('/media/{path}', [FileManagerModule::class, "getFile"])->where('path', '.*\.(jpg|jpeg|png|gif|bmp|svg)$');
Route::get('/answer/{path}', [FileManagerModule::class, "getFile"])->where('path', '.*\.(jpg|jpeg|png|gif|bmp|svg|mp4|mov|avi|flv)$');
Route::get('/{any}', function () {
    return file_get_contents(public_path('index.html'));
})->where('any', '^(?!.*\.(json|png|jpg)$).*$');
