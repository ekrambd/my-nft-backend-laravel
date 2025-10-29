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