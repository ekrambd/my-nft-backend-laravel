<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// ================== Admin Auth ==================
Route::prefix('admin')->group(function () {

    // Limit admin login attempts to 5 per minute per IP
    Route::post('/login', [AuthController::class, 'adminLogin'])
        ->middleware('throttle:5,1');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'adminLogout'])
            ->middleware('throttle:20,1'); // Optional: 20 requests/min for safety
    });
});

// ================== User Auth ==================
Route::prefix('user')->group(function () {

    // Limit registration and login to 5 per minute per IP
    Route::post('/register', [AuthController::class, 'userRegister'])
        ->middleware('throttle:5,1');

    Route::post('/login', [AuthController::class, 'userLogin'])
        ->middleware('throttle:5,1');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'userLogout'])
            ->middleware('throttle:20,1');
    });
});
