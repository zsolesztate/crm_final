<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $this->user->id, 'min:10', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'regex:/^[+\/\-\s\d]+$/'],
            'position' => ['required','string','max:255'],
            'active_status' => ['required', 'boolean'],
            'can_modify' => ['required', 'boolean'],
            'role' => ['required'],
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
        ];
    }
}
