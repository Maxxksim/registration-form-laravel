<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['sometimes', 'required', 'string', 'max:100'],
            'last_name' => ['sometimes', 'required', 'string', 'max:100'],
            'birthdate' => ['sometimes', 'required', 'date', 'date_format:Y-m-d', 'before_or_equal:tomorrow'],
            'report_subject' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => ['sometimes', 'required', 'string', 'phone:AUTO'],
            'country' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'email', Rule::unique('members', 'email')->ignore($this->route('member')), 'max:255'],
            'company' => ['sometimes', 'nullable', 'string', 'max:255'],
            'position' => ['sometimes', 'nullable', 'string', 'max:255'],
            'about_me' => ['sometimes', 'nullable', 'string', 'max:500'],
            'photo' => ['sometimes', 'nullable', 'file', 'image', 'mimes:png,jpeg,webp', 'max:3024'],
            'is_visible' => ['sometimes', 'bool'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.phone' => 'Please enter a valid phone number.',
        ];
    }
}
