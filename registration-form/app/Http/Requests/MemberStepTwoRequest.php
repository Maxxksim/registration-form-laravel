<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class MemberStepTwoRequest extends MemberRequest
{
    public function rules(): array
    {
        return Arr::only(parent::rules(), ['company', 'position', 'about_me', 'photo']);
    }
}
