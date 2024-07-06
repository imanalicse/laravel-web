<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function home() {
        return view('page.home');
    }

    public function profile()
    {
        return view('page.profile');
    }
}
