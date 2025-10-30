<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NftController;
use App\Http\Controllers\MintController;

Route::middleware(['auth:sanctum','mint.check'])->group(function () {
	//nfts
    Route::apiResource('nfts', NftController::class);
    //app setttings
    Route::prefix('settings')->group(function () {
    	Route::get('/info', [SettingController::class, 'info']);
    	Route::post('/app', [SettingController::class, 'appSettings']);
    });
}); 