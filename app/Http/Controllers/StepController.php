<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\MemberStepOneRequest;
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
            'currentStep' => 'one',
        ]);
    }

    public function stepOne(MemberStepOneRequest $memberStepOneRequest): RedirectResponse
    {
        Member::create($memberStepOneRequest->validated());
        session(['currentStep' => 'two']);

        return redirect('/register/steps/two');
    }
}
