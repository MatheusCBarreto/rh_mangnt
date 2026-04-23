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

    public function showDetails($id)
    {

        Auth::user()->can('admin', 'rh') ?: abort(403, 'You do not have permission to access this page.');

        // check if id is the same as the auth user
        if (Auth::user()->id == $id) {
            return redirect()->route('home');
        }

        $colaborators = User::with('detail', 'department')->where('id', $id)->first();

        return view('colaborators.show-details', ['colaborator' => $colaborators]);
    }
}
