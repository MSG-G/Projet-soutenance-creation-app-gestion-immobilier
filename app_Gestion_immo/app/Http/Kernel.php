<?php

namespace App\Http;

class Kernel{
    protected $routeMiddleware = [
        'role' => \App\Http\Middleware\CheckRole::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStatefulFromSanctum::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

    ];
}
