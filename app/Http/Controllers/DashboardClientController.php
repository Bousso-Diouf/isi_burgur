<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardClientController extends Controller
{
    public function index()
    {
        return view('client.dashboard');
    }
}