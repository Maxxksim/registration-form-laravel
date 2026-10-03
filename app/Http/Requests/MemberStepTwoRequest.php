<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberStepTwoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'company' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'about_me' => ['nullable', 'string', 'max:500'],
            'photo' => ['nullable', 'file', 'image', 'mimes:png,jpeg,webp', 'max:3024'],
        ];
    }
}
