<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboard extends Controller
{
    public function dashboard()
    {
        return view('dashboard.dashboard');
    }
}
