<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmAccountEmail;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RhUserController extends Controller
{
    public function index()
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        $colaborators = User::withTrashed()->with('detail')->where('role', 'rh')->get();

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
            'address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'city' => 'required|string|max:50',
            'phone' => 'required|string|max:50',
            'salary' => 'required|decimal:2',
            'admission_date' => 'required|date_format:Y-m-d',
        ]);

        // check if department id == 2
        if ($request->select_department != 2) {
            return redirect()->route('home');
        }

        // user confirmation token
        $token = Str::random(60);

        // create new RH user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->confirmation_token = $token;
        $user->role = 'RH';
        $user->department_id = $request->select_department;
        $user->permissions = '["RH"]';
        $user->save();

        // save user datails
        $user->detail()->create([
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'city' => $request->city,
            'phone' => $request->phone,
            'salary' => $request->salary,
            'admission_date' => $request->admission_date,
        ]);

        // send email to user
        Mail::to($user->email)->send(new ConfirmAccountEmail(route('confirm-account', $token)));

        return redirect()->route('colaborators.rh-users')->with('success', 'Colaborator created successfully.');
    }

    public function editRhColaborator($id)
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        $colaborator = User::with('detail')->findOrFail($id);

        return view('colaborators.edit-rh-user', ['colaborator' => $colaborator]);
    }

    public function updateRhColaborator(Request $request)
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        // form validation
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'salary' => 'required|decimal:2',
            'admission_date' => 'required|date_format:Y-m-d'
        ]);

        $user = User::findOrFail($request->user_id);
        $user->detail->update([
            'salary' => $request->salary,
            'admission_date' => $request->admission_date
        ]);

        return redirect()->route('colaborators.rh-users');
    }

    public function deleteRhColaborator($id)
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        $colaborator = User::where('id', $id)->findOrFail($id);

        return view('colaborators.delete-rh-user', ['colaborator' => $colaborator]);
    }

    public function deleteRhColaboratorConfirm($id)
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        $colaborator = User::findOrFail($id);
        $colaborator->delete();

        return redirect()->route('colaborators.rh-users');
    }

    public function restoreRhColaborator($id)
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');


        $colaborator = User::withTrashed()->where('role', 'rh')->findOrFail($id);

        $colaborator->restore();

        return redirect()->route('colaborators.rh-users');
    }
}
