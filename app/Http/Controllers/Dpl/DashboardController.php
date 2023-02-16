<?php

namespace App\Http\Controllers\Dpl;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dpl.dashboard');
    }
}
