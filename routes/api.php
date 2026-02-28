<?php

use App\Http\Controllers\Api\v1\AuthentificationController;
use App\Http\Controllers\Api\v1\ModuleController;
use App\Http\Controllers\Api\v1\ShortenedLinkController;
use Illuminate\Support\Facades\Route;






Route::prefix('v1')->group(function () {
    route::get('/lllll', function () {
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


        Route::apiResource('modules', controller: ModuleController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy']);

        Route::post('/modules/{id}/activate', [ModuleController::class, 'activate'])
            ->name('api.v1.modules.activation');

        Route::post('/modules/{id}/deactivate', [ModuleController::class, 'deactivate'])
            ->name('api.v1.modules.deactivate');

    });

    Route::middleware(CheckModuleActive::class)->group(function () {
        // URL Shortener routes
        Route::post('/shorten', [ShortenedLinkController::class, 'store'])
            ->name('api.v1.shorten.store');
        Route::get('/links', [ShortenedLinkController::class, 'index'])
            ->name('api.v1.links.index');
        Route::delete('/links/{id}', [ShortenedLinkController::class, 'destroy'])
            ->name('api.v1.links.destroy');

    });

    Route::middleware('CheckModuleActive:UrlShortener')->group(function () {
        Route::get('/s/{code}', [ShortenedLinkController::class, 'redirect'])
            ->name('api.v1.shorten.redirect');
    });
});