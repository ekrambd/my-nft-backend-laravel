<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MintController;

Route::middleware(['auth:sanctum','mint.check'])->group(function () {
	//mints
    Route::post('save-mint', [MintController::class, 'saveMint']);
    Route::get('/mints', [MintController::class, 'mints']);
});