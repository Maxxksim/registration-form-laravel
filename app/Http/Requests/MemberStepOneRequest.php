<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberStepOneRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'birthdate' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
            'report_subject' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'phone:AUTO'],
            'country' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', Rule::unique('members')->ignore($this->session()->get('memberData.email'), 'email'), 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.phone' => 'Please enter a valid phone number.',
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
            'report_subject.required' => 'The report subject field is required.'
        ];
    }
}
