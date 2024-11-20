<?php

namespace App\Http\Controllers\Auth;

use App\Enum\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function registration() {
        return view("auth.register");
    }

    public function registrationSubmit(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $role = Role::where('name', UserRole::CUSTOMER)->first();
        if (!empty($role)) {
            $role_id = $role['id'];
            $user->roles()->attach($role_id);
        }

        // Auth::login($user);
        // Auth::guard('admin')->login($user);

        return redirect('login')->with('success', 'Registration completed, now you can login');
    }
}
