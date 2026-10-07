<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\AdminPanel\MemberResource;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\Intl\Countries;

class AdminPanelController extends Controller
{
    public function index(): RedirectResponse|Response
    {
        if (! Auth::check()) {
            return redirect(route('admin.login.index'));
        }

        return Inertia::render('AdminPanel', [
            'members' => Inertia::scroll(MemberResource::collection(Member::paginate(12))),
            'countries' => Countries::getNames('en'),
        ]);
    }
}
