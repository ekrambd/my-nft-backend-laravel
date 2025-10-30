<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NftController;
use App\Http\Controllers\MintController;
use App\Http\Controllers\SettingController;

Route::middleware(['auth:sanctum', 'mint.check', 'throttle:60,1'])->group(function () {

    // NFTs routes
    Route::apiResource('nfts', NftController::class);

    Route::prefix('mints')->group(function () {
        Route::post('/save', [MintController::class, 'saveMint']);
        Route::get('/', [MintController::class, 'mints']);
    });

    // App settings
    Route::prefix('settings')->group(function () {
        Route::get('/info', [SettingController::class, 'info']);
        Route::post('/app', [SettingController::class, 'appSettings']);
    });
});
