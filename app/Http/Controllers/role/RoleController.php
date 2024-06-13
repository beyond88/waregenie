<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

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

        try {
            $role = Role::create($validated);

            return redirect()->route('role.create')
                ->with('message', 'Role created successfully!')
                ->with('type', 'success');

        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), 'roles_name_unique')) {
                session()->flash('error', 'The role name "'.$request->name.'" already exists. Please choose a different name.');

                return redirect()->back()->withInput();
            } else {
                return redirect()->back()->withInput();
            }
        }
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param int $id
     * @return View
     */
    public function edit($id): View
    {
        $role = Role::findOrFail($id);

        return view('role.edit', compact('role'));
    }

    /**
     * Update the specified role in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,'.$id, // Unique rule excluding current role
        ]);

        // If validation fails, redirect back with errors and input
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Find the role by ID or fail
        $role = Role::findOrFail($id);

        // Update the role with the request data
        $role->update($request->all());

        // Redirect to the roles list with a success message
        return redirect()->route('role')->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified role from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        // Find the role by ID or fail
        $role = Role::findOrFail($id);

        // Delete the role
        $role->delete();

        // Redirect to the roles list with a success message
        return redirect()->route('role')->with('success', 'Role deleted successfully!');
    }

}
