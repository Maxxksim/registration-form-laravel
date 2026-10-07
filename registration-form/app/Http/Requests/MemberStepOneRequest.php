<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\traits\MemberRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Symfony\Component\Intl\Countries;

class MemberStepOneRequest extends MemberRequest
{
    public function rules(): array
    {
        $rules = Arr::except(parent::rules(), ['company', 'position', 'about_me', 'photo']);
        $rules['email'][] = Rule::unique('members')->ignore($this->session()->get('memberData.email'), 'email');

        return $rules;
    }
}
