<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','email','unique:users','email','min:10','max:255'],
            'phone' => ['required', 'string', 'max:255', 'regex:/^[+\/\-\s\d]+$/'],
            'position' => ['required','string','max:255'],
            'role' => ['required'],
            'password' => ['required','string','min:8'],
            'active_status' =>['required','boolean'],
            'can_modify' =>['required','boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A név mező kitöltése kötelező.',
            'name.max' => 'A név maximum :max karakter hosszú lehet.',
            'email.required' => 'Az email mező kitöltése kötelező.',
            'email.email' => 'Az email mező érvényes email címet kell tartalmazzon.',
            'email.unique' => 'Ez az email cím már regisztrálva van.',
            'email.min' => 'Az email cím legalább :min karakter hosszú legyen.',
            'email.max' => 'Az email cím maximum :max karakter hosszú lehet.',
            'phone.required' => 'A telefonszám mező kitöltése kötelező.',
            'phone.regex' => 'A telefonszám csak számokat, szóközöket és kötőjeleket tartalmazhat.',
            'position.required' => 'A beosztás mező kitöltése kötelező.',
            'position.max' => 'A beosztás maximum :max karakter hosszú lehet.',
            'role.required' => 'Csoport kiválasztása kötelező',
            'password.required' => 'A jelszó mező kitöltése kötelező.',
            'password.min' => 'A jelszó legalább :min karakter hosszú legyen.',
        ];
    }
}
