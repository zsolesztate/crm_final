<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPasswordRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => ['required', 'string', 'min:8'],
            'confirmPassword' => ['required', 'string', 'same:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'A jelszó mező kitöltése kötelező.',
            'password.min' => 'A jelszó legalább :min karakter hosszú kell legyen.',
            'confirmPassword.min' => 'Az új jelszó legalább :min karakter hosszú kell legyen.',
            'confirmPassword.required' => 'A jelszó megerősítése mező kitöltése kötelező.',
            'confirmPassword.same' => 'A jelszó és a jelszó megerősítése nem egyezik meg.',
        ];
    }
}
