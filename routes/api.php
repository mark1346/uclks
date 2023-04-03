<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentContoller;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('/login', [AuthController::class, 'login']);
Route::post('/password/forgot', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/departments', [DepartmentContoller::class, 'index']);
Route::get('/departments/search', [DepartmentContoller::class, 'search']);
Route::get('/departments/{id}', [DepartmentContoller::class, 'show']);
Route::get('/modules/{id}', [ModuleController::class, 'show']);
Route::get('/modules/{id}/average', [ModuleController::class, 'average']);

Route::group([
    'middleware' => "auth:sanctum",
], function () {
    Route::get('/user', [AuthController::class, 'getUserInfo']);
    Route::get('/profile', [AuthController::class, 'getUserProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put("/password/edit", [AuthController::class, 'changePassword']);
    Route::put("/email/edit", [AuthController::class, 'changeEmail']);
    Route::put("/profile/edit", [AuthController::class, 'updateProfile']);
});

Route::group(['middleware' => ["auth:sanctum", "throttle:6,1"]], function () {
    Route::post('/email/verify/resend', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(["resend-email"], 200);
    });
});

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, '__invoke'])->middleware((['signed', 'throttle:6, 1']))->name('verification.verify');
