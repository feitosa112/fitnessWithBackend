<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;




     class RegisteredUserController extends Controller
{
    public function store(RegisterUserRequest $request)
    {
         Log::info('Dolazak na register:', $request->all());
        // validacija unosa


        // kreiranje korisnika
        $user = User::create([

            'email' => $request->email,
            'goals'=>$request->goals,
            'training_type'=>$request->training_type,
            'password' => Hash::make($request->password),
        ]);
Log::info('Registracija korisnika:', $request->all());
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,

        ], 201);
    }
}

