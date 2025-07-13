<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DasborController extends Controller
{
    function index(Request $request)
    {
        return view("dasbor");
    }
}
