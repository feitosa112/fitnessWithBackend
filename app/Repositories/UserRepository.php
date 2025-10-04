<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    // Vrati korisnika po emailu
    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    // Kreiraj novog korisnika
    public function create(array $data)
    {
        return User::create($data);
    }

    // Možeš dodati još metode po potrebi
}
