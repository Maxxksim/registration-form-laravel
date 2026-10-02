<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMemberRequest;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class MemberController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Members', [
            'members' => Member::where('is_visible', true)->paginate(10)->toResourceCollection(),
        ]);
    }

    public function switchVisibility(Member $member, UpdateMemberRequest $updateMemberRequest): RedirectResponse
    {
        $member->is_visible = $updateMemberRequest->validated()['is_visible'];
        $member->save();

        return back();
    }

    public function delete(Member $member): RedirectResponse
    {
        Storage::disk('public')->delete($member->path_to_photo);
        $member->delete();

        return back();
    }

    public function update(Member $member, UpdateMemberRequest $updateMemberRequest): RedirectResponse
    {
        $validatedData = $updateMemberRequest->safe()->except('photo');
        if ($updateMemberRequest->hasFile('photo')) {
            $pathToPhoto = $updateMemberRequest->image('photo')->toWebp()->store('photos', 'public');
            if ($member->path_to_photo) {
                Storage::disk('public')->delete($member->path_to_photo);
            }
            $validatedData['path_to_photo'] = $pathToPhoto;
        }

        $member->update($validatedData);

        return back();
    }
}
