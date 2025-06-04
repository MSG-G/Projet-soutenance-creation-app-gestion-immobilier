<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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



Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
})->middleware('web');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});




Route::post('/login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Admin-only routes
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::get('users/search', [UserController::class, 'search']);
    });

    // Admin and Agent routes
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

    // Client routes
    Route::middleware('role:client')->group(function () {
        Route::apiResource('reservations', ReservationController::class)->only(['store']);
    });

    // Routes accessibles à tous les utilisateurs authentifiés
    Route::apiResource('biens', BienController::class)->only(['index', 'show']);
    Route::apiResource('messages', MessageController::class);
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::put('notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
});
