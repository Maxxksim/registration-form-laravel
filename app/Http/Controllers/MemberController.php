<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Member;
use Inertia\Inertia;
use Inertia\Response;

class MemberController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Members', [
            'members' => Member::paginate(20)->toResourceCollection(),
        ]);
    }
}
