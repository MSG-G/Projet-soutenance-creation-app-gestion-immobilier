<?php

use Illuminate\Support\Facades\Route;

// Rediriger toutes les requêtes web vers l'API
Route::get('/{any}', function () {
    return response()->json(['message' => 'Veuillez utiliser les endpoints API appropriés'], 404);
})->where('any', '.*');