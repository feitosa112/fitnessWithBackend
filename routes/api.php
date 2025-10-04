<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Request;

Route::middleware('auth:sanctum')->get('/user', function(Request $request) {
    return $request->user();
});

Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');


