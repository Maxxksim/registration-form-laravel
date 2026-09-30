<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\MemberStepOneRequest;
use App\Http\Requests\MemberStepTwoRequest;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\Intl\Countries;

class StepController extends Controller
{
    public function index(Request $request): RedirectResponse
    {
        if (!$request->session()->has('currentStep')) {
            $request->session()->put('currentStep', 'one');

            return redirect('/register/steps/one');
        }

        return redirect('/register/steps/' . $request->session()->get('currentStep'));
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
        return Inertia::render('StepTwo', []);
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
        $memberStepOneRequest->session()->put(['currentStep' => 'two', 'memberData' => $member->only('first_name', 'last_name', 'birthdate', 'report_subject', 'country', 'phone', 'email', 'id')]);

        return redirect('/register/steps/two');
    }

    public function stepTwo(MemberStepTwoRequest $memberStepTwoRequest): RedirectResponse
    {
        $pathToPhoto = null;
        if ($memberStepTwoRequest->hasFile('photo')) {
            $pathToPhoto = $memberStepTwoRequest->image('photo')->toWebp()->store('photos', 'public');
        }

        Member::where('id', $memberStepTwoRequest->session()->get('memberData')['id'])->update(array_merge(
            $memberStepTwoRequest->safe()->except('photo'),
            ['path_to_photo' => $pathToPhoto]
        ));

        $memberStepTwoRequest->session()->put(['currentStep' => 'thanks']);

        return redirect('/register/steps/thanks');
    }
}
