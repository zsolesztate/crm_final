<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search' => 'sometimes|required|string|min:3|max:150|regex:/^[a-zA-Z0-9\sáÁéÉíÍóÓöÖőŐúÚüÜűŰ.\-]*$/',
            'user' => 'sometimes|required|integer',
            'contact' => 'sometimes|required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'search.min' => 'Az keresési érték legalább :min karakter hosszú kell legyen.',
            'search.max' => 'A keresési érték maximum :max karakter hosszú lehet.',
            'search.regex' => 'A keresési érték csak számokat, betűket és ékezetes betűket tartalmazhat.'
        ];
    }
}
