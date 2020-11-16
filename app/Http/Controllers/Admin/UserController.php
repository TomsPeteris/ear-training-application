<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all()->map(function (User $user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'role' => $user->role,
                'avatar' => $user->getAvatarPath(),
                'created_at' => date('D m Y H:i', strtotime($user->created_at)),
            ];
        });

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'store' => route('users.store'),
        ]);
    }

    public function create() {
        return Inertia::render('Admin/Users/Create', [
            'roles' => User::ROLES,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'username' => ['required', 'max:255', 'unique:users', 'alpha_dash'],
            'full_name' => ['required', 'max:255'],
            'email' => ['required', 'max:50', 'email', 'unique:users'],
            'password' => ['required', 'max:50', 'min:8', 'confirmed'],
            'avatar' => ['sometimes', 'image'],
        ]);

        User::create([
            'username' => $request->input('username'),
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'avatar' => $request->file('avatar')
                ? $request->file('avatar')->store('avatars')
                : null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('users')->with('success', 'User created.');
    }

    public function edit(User $user)
    {
        return Inertia::render('Admin/Users/Edit', [
            'roles' => User::ROLES,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'photo' => $user->photo,
                'role' => $user->role,
            ],
        ]);
    }

    public function update(Request $request, User $user)
    {
        $attributes = $request->validate([
            'username' => ['required', 'max:50'],
            'full_name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')->ignore($user)],
            'password' => ['sometimes', 'required', 'min:8', 'max:50', 'confirmed'],
            'avatar' => ['sometimes', 'image'],
            'role' => ['sometimes'],
        ]);

        if ($request->input('password')) {
            $attributes['password'] = Hash::make($request->input('password'));
        }

        if ($request->file('avatar')) {
            $attributes['avatar'] = $request->file('avatar')->store('avatars');
        }

        if ($request->input('role')) {
            $attributes['role'] = $request->input('role');
        }

        $user->update($attributes);

        return redirect()->route('users')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->user()->id) {
            return redirect()->route('users')->with('error', 'You cannot delete your profile here.');
        }

        $user->delete();

        return redirect()->route('users')->with('success', 'User deleted.');
    }
}
