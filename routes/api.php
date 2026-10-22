<?php

use App\Http\Controllers\Api\Auth\ForgotPasswordApiController;
use App\Http\Controllers\Api\Auth\LoginApiController;
use App\Http\Controllers\Api\Auth\LoginRegisterApiController;
use App\Http\Controllers\Api\Auth\LogoutApiController;
use App\Http\Controllers\Api\Auth\PasswordUpdateApiController;
use App\Http\Controllers\Api\Auth\RegisterApiController;
use App\Http\Controllers\Api\Auth\ResetPasswordApiController;
use App\Http\Controllers\Api\Auth\OtpApiController;
use App\Http\Controllers\Api\Auth\VerifyAuthApiController;
use App\Http\Controllers\Api\User\AvatarApiController;
use App\Http\Controllers\Api\User\ProfileApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:5,1')->group(function () {
    Route::post('/auth/send-otp', [OtpApiController::class, 'send']);
    Route::post('/auth/verify-otp', [OtpApiController::class, 'verify']);
});

// Login, Register, Reset Password
Route::middleware(['cors_api'])->group(function () {
    Route::post('register', [RegisterApiController::class, 'register']);
    Route::post('login', [LoginApiController::class, 'login']);
    Route::post('login-register', LoginRegisterApiController::class);
    Route::post('/forgot-password', [ForgotPasswordApiController::class, 'forgotPassword'])->middleware(
        'throttle:3,10',
    );
    Route::post('/reset-password', [ResetPasswordApiController::class, 'resetPassword']);
});

Route::middleware('auth:sanctum')->group(function () {
    // Logout
    Route::post('logout', [LogoutApiController::class, 'logout']);
    Route::get('/auth/verify', VerifyAuthApiController::class);

    // Profile
    Route::get('/profile', [ProfileApiController::class, 'show']);
    Route::put('/profile', [ProfileApiController::class, 'update']);

    // Password Update
    Route::put('password', [PasswordUpdateApiController::class]);

    // Avatar, Photo
    Route::post('/avatar', [AvatarApiController::class, 'store']);
    Route::delete('/avatar', [AvatarApiController::class, 'destroy']);
});
