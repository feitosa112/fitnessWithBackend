<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming login request.
     */
    public function store (LoginRequest $request): JsonResponse
    {
        Log::info('Dolazak na login:', $request->all());

        // Traži korisnika direktno iz User modela
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Neispravan email ili lozinka'], 401);
        }

        // Snimanje vremena poslednjeg logina
        Log::info('Prije snimanja last_login_at:', ['user' => $user->id, 'vrijeme' => now()]);
        $user->last_login_at = now();
        $user->save();
        Log::info('Last login snimljen:', ['vrijednost' => $user->last_login_at]);

        // Logovanje korisnika
        Auth::login($user);

        // Vraćanje odgovora
        return response()->json([
            'message' => 'Uspješan login',
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
            ],
        ]);
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
