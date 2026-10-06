<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\Intl\Countries;

class UpdateMemberRequest extends MemberRequest
{
    public function rules(): array
    {
        $rules = array_map(fn(array $otherRules): array => ['sometimes', ...$otherRules], parent::rules());
        $rules['email'][] = Rule::unique('members', 'email')->ignore($this->route('member'));

        return $rules;
    }

}
