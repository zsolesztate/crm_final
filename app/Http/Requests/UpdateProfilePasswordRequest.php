<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdateProfilePasswordRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'currentPassword' => ['required', function ($attribute, $value, $fail) {
                $user = auth()->user();
                if (!Hash::check($value, $user->password)) {
                    return $fail(__('A megadott jelszó nem egyezik meg a jelenlegi jelszóval.'));
                }
            }],
            'newPassword' => ['required','string','min:8'],
            'confirmPassword' => ['required','string','same:newPassword'],
        ];
    }

    public function messages(): array
    {
        return [
            'currentPassword.required' => 'A jelszó mező kitöltése kötelező.',
            'currentPassword.min' => 'A jelszó legalább :min karakter hosszú kell legyen.',
            'newPassword.required' => 'Az új jelszó mező kitöltése kötelező.',
            'newPassword.min' => 'Az új legalább :min karakter hosszú kell legyen.',
            'newPassword.same' => 'Az új jelszó és a jelszó megerősítése nem egyezik meg.',
            'confirmPassword.required' => 'Az új jelszó megerősítése mező kitöltése kötelező.',
            'confirmPassword.same' => 'Az új jelszó és az új jelszó megerősítése nem egyezik meg.',
        ];
    }

}
