<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MemberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birthdate' => $this->birthdate,
            'report_subject' => $this->report_subject,
            'phone' => $this->phone,
            'country' => $this->country,
            'email' => $this->email,
            'company' => $this->company,
            'about_me' => $this->about_me,
            'photo_url' => asset(Storage::url($this->path_to_photo ?? 'photos/default.webp'))
        ];
    }
}
