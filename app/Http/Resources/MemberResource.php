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
            'full_name' => "$this->first_name $this->last_name",
            'photo_url' => $this->path_to_photo ? asset(Storage::url($this->path_to_photo)) : asset('images/default/default-photo.webp'),
            'report_subject' => $this->report_subject,
            'email' => $this->email
        ];
    }
}
