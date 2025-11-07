<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('user')->group(function () {
    Route::post('/register', [UserController::class, 'store']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/verify/email', [UserController::class, 'verifyEmail']);
    Route::patch('/verification/resend', [UserController::class, 'resendVerificaticonCode']);
    Route::middleware(['auth:sanctum'])->get('/{id}', [UserController::class, 'show']);
    Route::middleware(['auth:sanctum'])->delete('/logout/{id}', [UserController::class, 'logout']);
});
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add', [CartController::class, 'addToCart']);
    Route::delete('/remove/{id}', [CartController::class, 'removeFromCart']);
});
