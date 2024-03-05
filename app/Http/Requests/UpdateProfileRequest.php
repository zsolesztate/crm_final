<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'min:10', 'max:255', 'unique:users,email,' . $this->user->id],
            'phone' => ['required', 'string', 'max:255', 'regex:/^[+\/\-\s\d]+$/'],
            'position' => ['required','string','max:255'],
        ];
    }
}
