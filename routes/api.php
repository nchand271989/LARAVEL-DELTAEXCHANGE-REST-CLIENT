<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\DeltaExchangeController;

Route::get('/assets', [DeltaExchangeController::class, 'assets']);
Route::get('/indices', [DeltaExchangeController::class, 'indices']);
Route::get('/account-balance', [DeltaExchangeController::class, 'accountBalance']);
Route::post('/place-order', [DeltaExchangeController::class, 'placeOrder']);