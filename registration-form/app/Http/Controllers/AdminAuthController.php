<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AdminAuthRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AdminAuthController extends Controller
{
    public function login(AdminAuthRequest $request): RedirectResponse
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.panel'));
        }

        return back()->withErrors([
            'credentials' => 'The provided credentials do not match our records.',
        ]);
    }

    public function index(): Response
    {
        return Inertia::render('AdminAuth');
    }
}
