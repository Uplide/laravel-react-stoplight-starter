<?php

use App\Http\Controllers\Mobile\Answer\AnswerController;
use App\Http\Controllers\Mobile\Answer\AnswerImageController;
use App\Http\Controllers\Mobile\Answer\AnswerImageTextController;
use App\Http\Controllers\Mobile\Answer\AnswerTextController;
use App\Http\Controllers\Mobile\Answer\AnswerVideoController;
use App\Http\Controllers\Mobile\Answer\AnswerVideoTextController;
use App\Http\Controllers\Mobile\Answer\AnswerVoiceController;
use App\Http\Controllers\Mobile\Answer\AnswerVoiceTextController;
use App\Http\Controllers\Mobile\AuthController;
use App\Http\Controllers\Mobile\ProfileController;
use App\Http\Controllers\Mobile\ProjectController;
use App\Http\Controllers\Mobile\CategoryController;
use App\Http\Controllers\Mobile\QuestionController;
use App\Http\Controllers\Mobile\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('login/verify', [AuthController::class, "loginVerify"]);
Route::post('register', [AuthController::class, 'register']);
Route::post('register/email/verify', [AuthController::class, 'registerEmailVerify']);
Route::post('register/email/resend', [AuthController::class, 'registerEmailResend']);
Route::post('register/phone/verify', [AuthController::class, 'registerPhoneVerify']);
Route::post('register/phone/resend', [AuthController::class, 'registerPhoneResend']);
Route::get('register/steps', [AuthController::class, 'registerSteps']);
Route::post('register/step', [AuthController::class, 'registerStep']);
Route::middleware(["token-valid", "auth:user-api"])->group(function () {
    Route::get('current', [AuthController::class, 'current']);
    Route::get('logout', [AuthController::class, 'logout']);

    Route::prefix('profile')->group(function () {
        Route::get("/", [ProfileController::class, "profile"]);
        Route::post("/feedback", [ProfileController::class, "feedback"]);
    });
    Route::prefix('project')->group(function () {
        Route::get("/", [ProjectController::class, "projects"]);
        Route::get("/{id}", [ProjectController::class, "getProject"]);
    });
    Route::prefix('category')->group(function () {
        Route::get("/", [CategoryController::class, "categories"]);
    });

    Route::prefix('task')->group(function () {
        Route::get("/{id}", [TaskController::class, "getTask"]);
    });

    Route::prefix('question')->group(function () {
        Route::get("/{id}", [QuestionController::class, "getQuestion"]);
        Route::get("/{id}/answers", [QuestionController::class, "getQuestionAnswers"]);
    });

    Route::prefix('answer')->group(function () {
        Route::get("/{id}/like", [AnswerController::class, "like"]);

        Route::prefix('/text')->group(function () {
            Route::post("/", [AnswerTextController::class, "create"]);
            Route::post("/update", [AnswerTextController::class, "update"]);
        });

        Route::prefix('/image')->group(function () {
            Route::post("/", [AnswerImageController::class, "create"]);
            Route::post("/update", [AnswerImageController::class, "update"]);
        });

        Route::prefix('/image-text')->group(function () {
            Route::post("/", [AnswerImageTextController::class, "create"]);
            Route::post("/update", [AnswerImageTextController::class, "update"]);
        });

        Route::prefix('/video')->group(function () {
            Route::post("/", [AnswerVideoController::class, "create"]);
            Route::post("/update", [AnswerVideoController::class, "update"]);
        });

        Route::prefix('/video-text')->group(function () {
            Route::post("/", [AnswerVideoTextController::class, "create"]);
            Route::post("/update", [AnswerVideoTextController::class, "update"]);
        });

        Route::prefix('/voice')->group(function () {
            Route::post("/", [AnswerVoiceController::class, "create"]);
            Route::post("/update", [AnswerVoiceController::class, "update"]);
        });

        Route::prefix('/voice-text')->group(function () {
            Route::post("/", [AnswerVoiceTextController::class, "create"]);
            Route::post("/update", [AnswerVoiceTextController::class, "update"]);
        });
    });
});
