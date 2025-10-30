<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//admin auth
Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'adminLogin']);
    Route::middleware('auth:sanctum')->group( function () { 
       Route::post('logout', [AuthController::class, 'adminLogout']);
    });
});

//user auth
Route::prefix('user')->group(function () {
	Route::post('/register', [AuthController::class, 'userRegister']);
    Route::post('/login', [AuthController::class, 'userLogin']);
    Route::middleware('auth:sanctum')->group( function () { 
       Route::post('logout', [AuthController::class, 'userLogout']);
    });
});