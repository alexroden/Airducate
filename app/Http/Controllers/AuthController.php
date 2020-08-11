<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class AuthController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function login()
    {
        return View::make('login');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        $user = Auth::user();

        Auth::logout();

        return Redirect::route('login');
    }
}
