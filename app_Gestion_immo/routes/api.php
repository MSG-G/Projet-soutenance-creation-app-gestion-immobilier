<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisteredUserController;
use App\Http\Controllers\API\AuthenticatedSessionController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProprietaireController;
use App\Http\Controllers\API\VilleController;
use App\Http\Controllers\API\TypeBienController;
use App\Http\Controllers\API\BienController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\ContratController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\PhotoController;

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::get('users/search', [UserController::class, 'search']);
    });

    Route::middleware('role:admin,agent')->group(function () {
        Route::apiResource('proprietaires', ProprietaireController::class);
        Route::get('proprietaires/search', [ProprietaireController::class, 'search']);
        Route::apiResource('villes', VilleController::class);
        Route::get('villes/search', [VilleController::class, 'search']);
        Route::apiResource('types-bien', TypeBienController::class);
        Route::get('types-bien/search', [TypeBienController::class, 'search']);
        Route::apiResource('biens', BienController::class)->except(['index', 'show']);
        Route::get('biens/search', [BienController::class, 'search']);
        Route::apiResource('reservations', ReservationController::class)->except(['store']);
        Route::get('reservations/search', [ReservationController::class, 'search']);
        Route::apiResource('contrats', ContratController::class);
        Route::apiResource('photos', PhotoController::class)->only(['store', 'destroy']);
    });

    Route::middleware('role:client')->group(function () {
        Route::apiResource('reservations', ReservationController::class)->only(['store']);
    });

    Route::apiResource('biens', BienController::class)->only(['index', 'show']);
    Route::apiResource('messages', MessageController::class);
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::put('notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
});
