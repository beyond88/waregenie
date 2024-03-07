<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        return view('role.role');
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
            'description' => 'nullable|string', // Allow description to be optional
        ]);

        $role = Role::create($validated);

        return redirect()->route('role.create')
            ->with('message', 'Role created successfully!')
            ->with('type', 'success'); // Add type for message styling
    }
}
