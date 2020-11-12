<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
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
                'role' => $user->role()->first()->role,
                'avatar' => $user->getAvatar(),
                'created_at' => date('D m Y H:i', strtotime($user->created_at)),
            ];
        });

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'store' => route('users.store'),
        ]);
    }

    public function create() {
        $roles = Role::all();

        return Inertia::render('Admin/Users/Create', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'username' => ['required', 'max:255', 'unique:users', 'alpha_dash'],
            'full_name' => ['required', 'max:255'],
            'email' => ['required', 'max:50', 'email', 'unique:users'],
            'password' => ['required', 'max:50', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'file'],
        ]);

        User::create([
            'username' => $request->input('username'),
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $request->input('role'),
            'avatar' => $request->file('avatar')->store('avatars'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('users')->with('success', 'User created.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return Inertia::render('Admin/Users/Edit', [
            'roles' => $roles,
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
            'avatar' => ['sometimes', 'file'],
            'role_id' => ['sometimes', 'exists:roles,id'],
        ]);

        if ($request->input('password')) {
            $attributes['password'] = Hash::make($request->input('password'));
        }

        if ($request->file('avatar')) {
            $attributes['avatar'] = $request->file('avatar')->store('avatars');
        }

        if ($request->input('role_id')) {
            $attributes['role_id'] = $request->input('role_id');
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
