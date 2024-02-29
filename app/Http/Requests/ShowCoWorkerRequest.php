<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowCoWorkerRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'search' => 'sometimes|required|string|min:3||max:150|regex:/^[a-zA-Z0-9\sáÁéÉíÍóÓöÖőŐúÚüÜűŰ]*$/',
        ];
    }
}
