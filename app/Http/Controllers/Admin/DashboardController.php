<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Attributes\Controllers\Middleware;

#[Middleware('auth:admin')]
class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
}
