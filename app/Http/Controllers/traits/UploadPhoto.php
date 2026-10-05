<?php

declare(strict_types=1);

namespace App\Http\Controllers\traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait UploadPhoto
{
    public function uploadPhotoIfExists(Request $request, ?string $oldPathToPhoto): string
    {
        if (! $request->hasFile('photo')) {
            return $oldPathToPhoto;
        }

        if ($oldPathToPhoto) {
            Storage::disk('public')->delete($oldPathToPhoto);
        }

        return $request->image('photo')->toWebp()->store('photos', 'public');
    }
}
