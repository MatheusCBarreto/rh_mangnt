<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(): View
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        $departments = Department::all();
        return view('department.departments', ['departments' => $departments]);
    }

    public function newDepartment(): View
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        return view('department.add-department');
    }

    public function createDepartment(Request $request)
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        $request->validate([
            'name' => 'required|string|max:50|unique:departments,name',
        ]);

        Department::create([
            'name' => $request->name
        ]);

        return redirect()->route('departments')->with('success', 'Department created successfully.');
    }
}
