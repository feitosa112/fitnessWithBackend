<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        Log::info('Dolazak na login:', $request->all());
        try {
            $request->authenticate();
        } catch (ValidationException $e) {
            // Ako login nije uspješan zbog kredencijala
            return response()->json([
                'message' => 'Neispravan email ili lozinka.',
            ], 401);
        }

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Uspješno ste prijavljeni.'
        ], 200);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Odjavljeni ste.'
        ], 200);
    }
}
