<?php

use App\Http\Controllers\Mobile\AuthController;
use App\Http\Controllers\Mobile\ProfileController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('login/verify', [AuthController::class, "loginVerify"]);
Route::post('register', [AuthController::class, 'register']);
Route::middleware(["token-valid", "auth:user-api"])->group(function () {
    Route::get('current', [AuthController::class, 'current']);
    Route::get('logout', [AuthController::class, 'logout']);

    Route::prefix('profile')->group(function () {
        Route::get("/", [ProfileController::class, "profile"]);
    });
});
