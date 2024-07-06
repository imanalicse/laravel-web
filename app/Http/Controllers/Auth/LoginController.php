<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */

    public function authenticate(Request $request) : RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

//        $remember_me = $request->get('remember_me');
//        $remember_me = filter_var($remember_me, FILTER_VALIDATE_BOOLEAN);
        // if (Auth::attempt($credentials, $remember_me)) {
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/profile');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
