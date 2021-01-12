<?php

namespace App\Http\Controllers\Front;

use App\Contracts\Profile\DeletesUserProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class ProfileController extends Controller
{
    /**
     * @return InertiaResponse
     */
    public function index(): InertiaResponse
    {
        return Inertia::render('Front/Profile/Index');
    }

    /**
     * @param Request $request
     * @param UpdatesUserProfileInformation $updater
     * @return RedirectResponse
     */
    public function updateProfileInformation(Request $request, UpdatesUserProfileInformation $updater): RedirectResponse
    {
        $updater->update($request->user(), $request->all());

        return redirect()->route('profile')->with('success', 'Profile information has been updated.');
    }

    /**
     * @param Request $request
     * @param UpdatesUserPasswords $updater
     * @return RedirectResponse
     */
    public function updatePassword(Request $request, UpdatesUserPasswords $updater): RedirectResponse
    {
        $updater->update($request->user(), $request->all());

        return redirect()->route('profile')->with('success', 'Password is updated.');
    }

    /**
     * @param Request $request
     * @param DeletesUserProfile $deleter
     * @return RedirectResponse
     */
    public function deleteProfile(Request $request, DeletesUserProfile $deleter): RedirectResponse
    {
        $deleter->delete($request->user(), $request->all());

        return redirect('/');
    }

}
