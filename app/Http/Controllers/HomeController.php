<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\Intl\Countries;

class HomeController extends Controller
{
    public function index(): Response
    {
        $countries = Countries::getNames('en');
        return Inertia::render('Home', [
            'countries' => $countries,
        ]);
    }
}
