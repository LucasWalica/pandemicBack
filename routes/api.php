<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PartidaController;

Route::prefix('partidas')->group(function () {
    Route::post('', [PartidaController::class,'store']);
    Route::get('/{id}', [PartidaController::class,'show']);
    Route::get('', [PartidaController::class,'getPartidasList']);
});

Route::prefix('auth')->group(function () {
    Route::post('register', [RegisteredUserController::class, 'store']);  // Asegúrate de que sea POST
    Route::post('login', [AuthenticatedSessionController::class, 'store']);  // Asegúrate de que sea POST
});