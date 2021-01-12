<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class AuthController extends Controller
{
    /**
     * @return InertiaResponse|RedirectResponse
     */
    public function login(): InertiaResponse|RedirectResponse
    {
        if (auth()->guest()) {
            return Inertia::render('Auth/Login');
        }

        return redirect()->back();
    }

    /**
     * @return InertiaResponse|RedirectResponse
     */
    public function register(): InertiaResponse|RedirectResponse
    {
        if (auth()->guest()) {
            return Inertia::render('Auth/Register');
        }

        return redirect()->back();
    }
}
