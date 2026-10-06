<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\traits\UploadPhoto;
use App\Http\Requests\UpdateMemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class MemberController extends Controller
{
    use UploadPhoto;

    public function index(): Response
    {
        return Inertia::render('Members', [
            'members' => Inertia::scroll(MemberResource::collection(Member::where('is_visible', true)->paginate())),
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
        if ($member->path_to_photo) {
            Storage::disk('public')->delete($member->path_to_photo);
        }
        $member->delete();

        return back();
    }

    public function update(Member $member, UpdateMemberRequest $updateMemberRequest): RedirectResponse
    {
        $validatedData = $updateMemberRequest->safe()->except('photo');
        $validatedData['path_to_photo'] = $this->uploadPhotoIfExists($updateMemberRequest, $member->path_to_photo);
        $member->update($validatedData);

        return back();
    }
}
