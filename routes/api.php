<?php

use App\Http\Controllers\Api\v1\AuthentificationController;
use Illuminate\Support\Facades\Route;






Route::prefix('v1')->group(function () {
    route::get('/lllll',function(){
        return 'ok';
    })->name('login');


    Route::post('/register', [AuthentificationController::class, 'register'])
        ->name('api.v1.register')
    ->middleware('api');


    Route::post('/login', [AuthentificationController::class, 'login'])
        ->name('api.v1.register')
    ->middleware('api');
    //route qui necessite d'etre authentifier en tant qu'users


    Route::middleware('auth:sanctum')->group(function () {


        Route::post('/logout', [AuthentificationController::class, 'logout'])
        ->name('api.v1.register')
        ->middleware('api');


        // Route::apiResource('commandes', CommandeController::class)
            // ->only(['index','show','store', 'update', 'destroy'])
        // ->middleware('api');


    });
});