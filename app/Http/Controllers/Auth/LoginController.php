<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login() {
        if (Auth::guard('web')->check()) {
            return redirect()->intended('/profile');
        }
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
        $credentials['active'] = 1;
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/profile');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function confirmPassword(Request $request) : RedirectResponse {
        if (! Hash::check($request->password, $request->user()->password)) {
            return back()->withErrors([
                'password' => ['The provided password does not match our records.']
            ]);
        }
        $request->session()->passwordConfirmed();
        return redirect()->intended();
    }
}
