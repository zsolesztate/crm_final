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
}
