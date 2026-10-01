<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AdminPanelController extends Controller
{
    public function index(): RedirectResponse|Response
    {
        if (!Auth::check()) {
            return redirect(route('admin.login.index'));
        }

        return Inertia::render('AdminPanel', [
            'members' => Member::paginate(5)->toResourceCollection(),
        ]);
    }
}
