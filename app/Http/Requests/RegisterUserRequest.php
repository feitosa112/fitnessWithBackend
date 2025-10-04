<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ako želiš, možeš dodati logiku autorizacije
    }

    public function rules()
    {
        return [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'goals' => 'required|array|min:1',
            'training_type' => 'required|string',
        ];
    }

    // Prilagođavanje JSON odgovora pri neuspješnoj validaciji
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'message' => 'Došlo je do greške u validaciji.',
            'errors' => $validator->errors()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
