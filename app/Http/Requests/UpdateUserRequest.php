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
}
