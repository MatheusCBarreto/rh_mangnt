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

        $colaborators = User::withTrashed()->with('detail', 'department')->where('role', '<>', 'admin')->get();

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

        // check if colaborator exists
        if (!$colaborators) {
            abort(404, 'Colaborator not found.');
        }

        return view('colaborators.show-details', ['colaborator' => $colaborators]);
    }

    public function deleteColaborator($id)
    {
        Auth::user()->can('admin', 'rh') ?: abort(403, 'You do not have permission to access this page.');

        if (Auth::user()->id == $id) {
            return redirect()->route('home');
        }

        $colaborator = User::findOrFail($id);
        return view('colaborators.delete-colaborator-confirm', ['colaborator' => $colaborator]);
    }

    public function deleteColaboratorConfirm($id)
    {
        Auth::user()->can('admin', 'rh') ?: abort(403, 'You do not have permission to access this page.');

        if (Auth::user()->id == $id) {
            return redirect()->route('home');
        }

        $colaborator = User::findOrFail($id);
        $colaborator->delete();

        return redirect()->route('colaborators.all-colaborators');
    }

    public function restoreColaborator($id)
    {
        Auth::user()->can('admin') ?: abort(403, 'You do not have permission to access this page.');

        $colaborator = User::withTrashed()->findOrFail($id);
        $colaborator->restore();

        return redirect()->route('colaborators.all-colaborators');
    }

    public function home()
    {
        Auth::user()->can('colaborator') ?: abort(403, 'You do not have permission to access this page.');

        $colaborator = User::with('detail', 'department')->where('id', Auth::user()->id)->first();

        return view('colaborators.show-details', ['colaborator' => $colaborator]);
    }
}
