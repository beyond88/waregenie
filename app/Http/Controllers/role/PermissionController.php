<?php

namespace App\Http\Controllers\role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $roles = Role::all();
        return view('role.permissions', compact('roles'));
    }

    public function loadPermissions(Request $request)
    {
        if ($request->ajax()) {
            $roleId = $request->get('role_id');
            $role = Role::find($roleId);
            $permissions = $role->permissions ?? [];
            return response()->json($permissions);
        } else {
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validationRules = [
            'role_id' => 'required|integer|max:20|exists:roles,id',
            'permissions' => 'nullable|array',
        ];

        $request->validate($validationRules);

        $roleId = $request->get('role_id');
        $permissions = $request->get('permissions', []);

        $role = Role::find($roleId);
        $role->permissions = $permissions;
        $saved = $role->save();

        if ($saved) {
            Session::flash('message', 'Permissions saved successfully!');
            Session::flash('type', 'success');
            return redirect()->route('permissions');
        } else {
            Session::flash('message', 'An error occurred while saving permissions!');
            Session::flash('type', 'danger');
            return back()->withInput();
        }

    }



}
