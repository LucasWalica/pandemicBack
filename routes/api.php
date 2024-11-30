<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PartidaController;

Route::group(['middleware' => 'api'], function () {

    Route::prefix('partidas')->group(function () {
        Route::post('', [PartidaController::class,'store'])->middleware('auth:sanctum');
        Route::get('/{id}', [PartidaController::class,'show'])->middleware('auth:sanctum');
        Route::get('', [PartidaController::class,'getPartidasList'])->middleware('auth:sanctum');
    });

    Route::prefix('auth')->group(function () {
        Route::post('register', [RegisteredUserController::class, 'store']);  
        Route::post('login', [AuthenticatedSessionController::class, 'store']);  
        Route::post('profilePic', [UserController::class, 'updateProfilePic'])->middleware('auth:sanctum');
        Route::get('profileData', [UserController::class, 'getProfileData'])->middleware('auth:sanctum');
    });

});