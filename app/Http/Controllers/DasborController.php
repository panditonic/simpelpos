<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DasborController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request)
    {
        return view("home");
    }
}
