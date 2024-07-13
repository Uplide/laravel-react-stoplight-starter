<?php

use App\Http\Controllers\Backoffice\AuthController;
use App\Http\Controllers\Backoffice\AdminController;
use App\Http\Controllers\Backoffice\CompanyController;
use App\Http\Controllers\Backoffice\FileManagerController;
use App\Http\Controllers\Backoffice\Project\ProjectController;
use App\Http\Controllers\Backoffice\RoleController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::middleware(["token-valid", "auth:admin-api"])->group(function () {
    Route::get('current', [AuthController::class, 'current']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::prefix("admin")->group(function () {
        Route::get('/', [AdminController::class, 'index'])->middleware("roles:ADMIN_VIEW");
        Route::post('/', [AdminController::class, 'store'])->middleware("roles:ADMIN_CREATE");
        Route::get('/{id}', [AdminController::class, 'get'])->middleware("roles:ADMIN_VIEW");
        Route::put('/{id}', [AdminController::class, 'update'])->middleware("roles:ADMIN_UPDATE");
        Route::delete('/{id}', [AdminController::class, 'delete'])->middleware("roles:ADMIN_DELETE");
    });

    Route::prefix("role")->group(function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::get('/{id}', [RoleController::class, 'get']);
        Route::put('/{id}', [RoleController::class, 'update']);
    });

    Route::prefix("project")->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->middleware("roles:PROJECT_VIEW");
        Route::post('/', [ProjectController::class, 'store'])->middleware("roles:PROJECT_CREATE");
        Route::get('/{id}', [ProjectController::class, 'show'])->middleware("roles:PROJECT_VIEW");
        Route::put('/{id}', [ProjectController::class, 'update'])->middleware("roles:PROJECT_UPDATE");
        Route::delete('/{id}', [ProjectController::class, 'destroy'])->middleware("roles:PROJECT_DELETE");
    });

    Route::prefix("company")->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->middleware("roles:COMPANY_VIEW");
        Route::post('/', [CompanyController::class, 'store'])->middleware("roles:COMPANY_CREATE");
        Route::get('/{id}', [CompanyController::class, 'show'])->middleware("roles:COMPANY_VIEW");
        Route::put('/{id}', [CompanyController::class, 'update'])->middleware("roles:COMPANY_UPDATE");
        Route::delete('/{id}', [CompanyController::class, 'destroy'])->middleware("roles:COMPANY_DELETE");
    });
});
Route::prefix("file-manager")->group(function () {
    Route::post('/upload', [FileManagerController::class, 'uploadFile']);
    Route::post('/create/folder', [FileManagerController::class, 'createFolder']);
    Route::get('/', [FileManagerController::class, 'index']);
    Route::post('/rename', [FileManagerController::class, 'rename']);
});
