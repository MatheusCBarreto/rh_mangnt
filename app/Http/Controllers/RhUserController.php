<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RhUserController extends Controller
{
    public function index()
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        $colaborators = User::where('role', 'rh')->get();

        return view('colaborators.rh-users', ['colaborators' => $colaborators]);
    }

    public function newColaborator()
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        // get all departments
        $departments = Department::all();

        return view('colaborators.add-rh-user', ['departments' => $departments]);
    }

    public function createRhColaborator(Request $request)
    {

        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        // form validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'select_department' => 'required|exists:departments,id',
        ]);

        // create new RH user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = 'RH';
        $user->department_id = $request->select_department;
        $user->permissions = '["RH"]';
        $user->save();

        return redirect()->route('colaborators.rh-users')->with('success', 'Colaborator created successfully.');
    }
}
