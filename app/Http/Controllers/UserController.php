<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function loginForm()
    {
        return view('user.login');
    }

    public function login()
    {
        $credentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();
            return redirect()->intended(route('admin.index'));
        } else {
            return back()->withErrors([
                'email' => 'Incorrecte e-mail of wachtwoord.'
            ]);
        }
    }

    public function resolveHome()
    {
        $permissions = Auth::user()->permissions;
        if (count($permissions) == 0 || !$permissions->contains('name', 'edit page')) {
            return view('layouts.admin');
        }
        return redirect()->route('page.index');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.index', ['users' => User::paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('user.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $details = request()->validate([
            'name' => ['required', 'unique:users,name', 'min:2', 'max:55'],
            'email' => ['required', 'unique:users,email', 'max:150', 'min:5', 'email'],
            'password' => ['required', 'min:5', 'max:255', 'confirmed'],
        ]);

        $details['password'] = Hash::make($details['password']);

        $user = User::create($details);

        $newPermissions = request('permissions') ?? [];
        $user->syncPermissions($newPermissions);

        return redirect()->route('user.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $permissions = Permission::all();
        $canDelete = Auth::getUser()->can('delete users');
        $me = $user->id == Auth::user()->id;
        return view('user.edit', compact('user', 'permissions', 'canDelete', 'me'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user)
    {
        $details = request()->validate([
            'name' => ['required', 'unique:users,name,' . $user->id, 'min:2', 'max:55'],
            'email' => ['required', 'unique:users,email,' . $user->id, 'min:5', 'max:255', 'email'],
            'password' => ['nullable', 'min:5', 'confirmed'],
        ]);

        if ($details['password'] != null) {
            $details['password'] = Hash::make($details['password']);
        } else {
            unset($details['password']);
        }

        $user->update($details);

        // Can't change your own permissions.
        if ($user->id != Auth::user()->id) {
            $newPermissions = request('permissions') ?? [];
            $user->syncPermissions($newPermissions);

            if (Auth::getUser()->id == $user->id && !in_array('edit users', $newPermissions)) {
                $this->logout();
                return redirect('/');
            }
        }

        return redirect()->back()->with('success', 'De gebruiker is aangepast.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!Auth::getUser()->can('delete users')) {
            return redirect()->back()->withErrors(['generic' => "De ingelogde gebruiker heeft geen verwijder rechten."]);
        }

        $username = $user->name;
        $user->delete();
        return redirect()->route('user.index')->with('success', "De gebruiker " . $username . " is verwijderd.");
    }


    public function logout()
    {
        request()->session()->flush();
        Auth::logout();
        return redirect()->intended();
    }
}
