<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\Intl\Countries;

class MemberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'birthdate' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:tomorrow'],
            'report_subject' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'phone:AUTO'],
            'country' => ['required', 'string', 'max:100', Rule::in(Countries::getNames('en'))],
            'email' => ['required', 'string', 'email', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'about_me' => ['nullable', 'string', 'max:500'],
            'photo' => ['nullable', 'file', 'image', 'mimes:png,jpeg,webp', 'max:3072'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.phone' => 'Please enter a valid phone number.',
            'country.in' => 'The selected country does not exist.'
        ];
    }
}
