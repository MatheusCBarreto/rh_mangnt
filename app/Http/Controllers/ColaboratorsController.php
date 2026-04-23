<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColaboratorsController extends Controller
{
    public function index()
    {

        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        $colaborators = User::with('detail', 'department')->where('role', '<>', 'admin')->get();

        return view('colaborators.admin-all-colaborators', ['colaborators' => $colaborators]);
    }
}
