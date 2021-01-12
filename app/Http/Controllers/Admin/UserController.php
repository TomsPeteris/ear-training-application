<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\User\DeletesUser;
use App\Contracts\User\CreatesUser;
use App\Contracts\User\UpdatesUser;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class UserController extends Controller
{
    /**
     * @return InertiaResponse
     */
    public function index(): InertiaResponse
    {
        $users = User::paginate(12)
            ->only('id', 'first_name', 'last_name', 'email', 'role', 'avatar', 'created_at')
            ->transform(function ($item) {
                return [
                    'id' => $item['id'],
                    'full_name' => $item['first_name'].' '.$item['last_name'],
                    'email' => $item['email'],
                    'role' => $item['role'],
                    'avatar' => $item['avatar'] ? asset('storage/'.$item['avatar']) : null,
                    'created_at' => date('D m Y H:i', strtotime($item['created_at']))
                ];
            });

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }

    /**
     * @return InertiaResponse
     */
    public function create(): InertiaResponse
    {
        return Inertia::render('Admin/Users/Create', [
            'roles' => User::ASSIGNABLE_ROLES,
        ]);
    }

    /**
     * @param Request $request
     * @param CreatesUser $creator
     * @return RedirectResponse
     */
    public function store(Request $request, CreatesUser $creator): RedirectResponse
    {
        $creator->create($request->all());

        return redirect()->route('users')->with('success', 'User has been successfully created.');
    }

    /**
     * @param User $user
     * @return InertiaResponse
     */
    public function edit(User $user): InertiaResponse
    {
        return Inertia::render('Admin/Users/Edit', [
            'roles' => User::ASSIGNABLE_ROLES,
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'avatar' => $user->getAvatarPath(),
                'role' => $user->role,
            ],
        ]);
    }

    /**
     * @param Request $request
     * @param UpdatesUser $updater
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, UpdatesUser $updater, User $user): RedirectResponse
    {
        $updater->update($user, $request->all());

        return redirect()->route('users')->with('success', 'User has been successfully updated.');
    }

    /**
     * @param DeletesUser $deleter
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(DeletesUser $deleter, User $user): RedirectResponse
    {
        $deleter->delete($user);

        return redirect()->route('users')->with('success', 'User has been successfully deleted.');
    }
}
