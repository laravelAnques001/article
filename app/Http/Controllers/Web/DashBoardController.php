<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class DashBoardController extends Controller
{
    public function dashboard()
    {
        return view('Admin.dashboard');
    }
}
