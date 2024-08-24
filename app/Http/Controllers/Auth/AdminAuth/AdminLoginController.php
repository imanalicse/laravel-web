<?php

namespace App\Http\Controllers\Auth\AdminAuth;

use App\Enum\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function login() {
        return view('auth.admin_login');
    }

    public function authenticate(Request $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::with('roles')->whereEmail($request->email)->first()->toArray();
        if(empty($user) || empty($user['roles'])) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $roles = $user['roles'];
        if (! $this->hasRole($roles, [UserRole::SUPER_ADMIN, UserRole::ADMIN])) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        // Auth::guard('admin')->login($user);

        $credentials['active'] = 1;
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
