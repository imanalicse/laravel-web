<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Routing\Attributes\Controllers\Middleware;

#[Middleware('auth:admin')]
class UsersController extends Controller
{
    function index(){
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
}
