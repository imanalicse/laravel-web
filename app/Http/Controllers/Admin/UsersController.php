<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    function index(){
        $users = DB::table('users')->get();
        return view('admin.users.index', compact('users'));
    }
}
