<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class MemberStepOneRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'birthdate' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
            'report_subject' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'phone:AUTO'],
            'country' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:members', 'max:255'],
        ];
    }
}
