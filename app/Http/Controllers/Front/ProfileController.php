<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return Inertia::render('Front/Profile/Index');

    }

    public function updateProfileInformation(Request $request)
    {

    }

    public function updatePassword()
    {

    }

    public function destroy()
    {

    }

}
