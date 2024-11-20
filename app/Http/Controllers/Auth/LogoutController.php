<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{

    public function logout(Request $request) : redirectResponse
    {
        $is_admin = false;
        if(Auth::guard('admin')->check()) {
            $is_admin = true;
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if ($is_admin) {
            return redirect('/admin/login');
        }
        return redirect('/');
    }
}
