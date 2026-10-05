<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MemberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birthdate' => $this->birthdate,
            'report_subject' => $this->report_subject,
            'phone' => $this->phone,
            'country' => $this->country,
            'email' => $this->email,
            'company' => $this->company,
            'position' => $this->position,
            'about_me' => $this->about_me,
            'photo_url' => $this->path_to_photo ? asset(Storage::url($this->path_to_photo)) : asset('images/default/default-photo.webp'),
            'is_visible' => $this->is_visible,
        ];
    }
}
