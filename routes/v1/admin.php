<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NftController;
use App\Http\Controllers\MintController;

Route::middleware(['auth:sanctum','mint.check'])->group(function () {
	//nfts
    Route::apiResource('nfts', NftController::class);
    //mints
    Route::post('save-mint', [MintController::class, 'saveMint']);
    Route::get('/mints', [MintController::class, 'mints']);
}); 