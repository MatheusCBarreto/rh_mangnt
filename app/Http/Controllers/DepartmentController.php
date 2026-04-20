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

    public function editDepartment($id)
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        return view('department.edit-department', ['department' => $department]);
    }


    public function updateDepartment(Request $request)
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        $id = $request->id;

        $request->validate([
            'id' => 'required',
            'name' => 'required|string|min:3|max:50|unique:departments,name,' . $id
        ]);

        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        $department->update([
            'name' => $request->name
        ]);

        return redirect()->route('departments');
    }

    public function deleteDepartment($id)
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        // display page for confirmation of deletion
        return view('department.delete-department-confirm', ['department' => $department]);
    }

    public function deleteDepartmentConfirm($id)
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        $department->delete();

        return redirect()->route('departments');
    }

    public function isDepartmentBlocked($id)
    {
        return in_array($id, [1, 2]);
    }
}
