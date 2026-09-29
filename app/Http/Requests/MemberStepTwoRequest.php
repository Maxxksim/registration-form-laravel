<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class MemberStepTwoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'company' => ['string', 'max:255'],
            'position' => ['string', 'max:255'],
            'about_me' => ['string', 'max:500'],
            'photo' => ['file', 'image', 'mimes:png,jpeg,webp', 'max:3024'],
        ];
    }
}
