<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::middleware('web')->group(function () {

    // Login
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // Authenticated user
    Route::middleware('auth')->get('/user', function () {
        $user = Auth::user();
        return response()->json([
            'id' => $user->id,
            'email' => $user->email,
        ]);
    });

    // Logout
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Logged out']);
    });
});







