<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(AdminRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            redirect('');
        }
    }
}
