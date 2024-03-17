<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index(Request $request): View
    {
        $roles = Role::paginate(20);
        return view('role.role', compact('roles'));
    }
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('role.create');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

//        $role = Role::create($validated);
//
//        return redirect()->route('role.create')
//            ->with('message', 'Role created successfully!')
//            -

        try {
            $role = Role::create($validated);
            return redirect()->route('role.create')
                ->with('message', 'Role created successfully!')
                ->with('type', 'success');

        } catch (\Illuminate\Database\QueryException $e) {
            if(str_contains($e->getMessage(), 'roles_name_unique')) {
                session()->flash('error', 'The role name "' . $request->name . '" already exists. Please choose a different name.');
                return redirect()->back()->withInput();
            } else {
                return redirect()->back()->withInput();
            }
        }
    }

    public function edit($id): View
    {
        $role = Role::findOrFail($id);

        return view('role.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $id, // Unique rule excluding current role
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $role = Role::findOrFail($id);

        $role->update($request->all());

        return redirect()->route('role')->with('success', 'Role updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('role')->with('success', 'Role deleted successfully!');
    }
}
