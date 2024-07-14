<?php

use App\Http\Controllers\Backoffice\AuthController;
use App\Http\Controllers\Backoffice\AdminController;
use App\Http\Controllers\Backoffice\FileManagerController;
use App\Http\Controllers\Backoffice\RoleController;
use Illuminate\Support\Facades\Route;

$ID = "{id}";

Route::post('login', [AuthController::class, 'login']);
Route::middleware(["token-valid", "auth:admin-api"])->group(function () use ($ID) {
    Route::get('current', [AuthController::class, 'current']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::prefix("admin")->group(function () use ($ID) {
        Route::get('/', [AdminController::class, 'index'])->middleware("roles:ADMIN_VIEW");
        Route::post('/', [AdminController::class, 'store'])->middleware("roles:ADMIN_CREATE");
        Route::get("/$ID", [AdminController::class, 'get'])->middleware("roles:ADMIN_VIEW");
        Route::get("/$ID/roles", [AdminController::class, 'getRoles'])->middleware("roles:ADMIN_VIEW_ROLE");
        Route::put("/$ID/roles", [AdminController::class, 'updateRoles'])->middleware("roles:ADMIN_UPDATE_ROLE");
        Route::put("/$ID", [AdminController::class, 'update'])->middleware("roles:ADMIN_UPDATE");
        Route::delete("/$ID", [AdminController::class, 'delete'])->middleware("roles:ADMIN_DELETE");
    });

    Route::prefix("roles")->group(function () {
        Route::get('/', [RoleController::class, 'index'])->middleware("roles:ADMIN_VIEW_ROLE");
    });
});
Route::prefix("file-manager")->group(function () {
    Route::post('/upload', [FileManagerController::class, 'uploadFile']);
    Route::post('/create/folder', [FileManagerController::class, 'createFolder']);
    Route::get('/', [FileManagerController::class, 'index']);
    Route::post('/rename', [FileManagerController::class, 'rename']);
});
