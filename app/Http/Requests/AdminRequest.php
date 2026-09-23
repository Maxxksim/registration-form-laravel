<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'username' => ['required', 'unique:admins', 'string', 'max:255', 'min:5'],
            'password' => ['required', 'string']
        ];
    }
}
