<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function home()
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        // display admin homepage
        return view('home');
    }
}
