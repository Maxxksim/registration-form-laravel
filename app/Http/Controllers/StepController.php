<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\traits\UploadPhoto;
use App\Http\Requests\MemberStepOneRequest;
use App\Http\Requests\MemberStepTwoRequest;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\Intl\Countries;

class StepController extends Controller
{
    use UploadPhoto;

    public function index(Request $request): RedirectResponse
    {
        if (! $request->session()->has('currentStep')) {
            $request->session()->put('currentStep', 'one');

            return redirect(route('steps.one.show'));
        }

        return redirect(route("steps.{$request->session()->get('currentStep')}.show"));
    }

    public function getStepOne(Request $request): Response
    {
        $countries = Countries::getNames('en');
        $initialCountry = Http::get("https://ipapi.co/{$request->ip()}/json")->json('country_code');

        return Inertia::render('StepOne', [
            'countries' => $countries,
            'initialCountry' => $initialCountry ?? 'US',
            'memberData' => $request->session()->get('memberData'),
        ]);
    }

    public function getStepTwo(): Response
    {
        return Inertia::render('StepTwo');
    }

    public function getStepThanks(): Response
    {
        return Inertia::render('StepThanks', [
            'countMembers' => Member::count(),
            'sharingData' => [
                'text' => config('sharing.text'),
                'url' => config('sharing.url'),
            ],
        ]);
    }

    public function stepOne(MemberStepOneRequest $memberStepOneRequest): RedirectResponse
    {
        $member = Member::updateOrCreate(['email' => $memberStepOneRequest->validated()['email']], $memberStepOneRequest->validated());
        $memberStepOneRequest->session()->put(['currentStep' => 'two', 'memberData' => $member->getAttributes()]);

        return redirect(route('steps.two.show'));
    }

    public function stepTwo(MemberStepTwoRequest $memberStepTwoRequest): RedirectResponse
    {
        $member = Member::find($memberStepTwoRequest->session()->get('memberData')['id']);
        $validatedData = $memberStepTwoRequest->safe()->except('photo');
        $validatedData['path_to_photo'] = $this->uploadPhotoIfExists($memberStepTwoRequest, $member->path_to_photo);
        $member->update($validatedData);

        $memberStepTwoRequest->session()->put(['currentStep' => 'thanks']);

        return redirect(route('steps.thanks.show'));
    }

    public function startOver(Request $request): RedirectResponse
    {
        Inertia::clearHistory();
        $request->session()->invalidate();

        return redirect(route('index.show'));
    }
}
