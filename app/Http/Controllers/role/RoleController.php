<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('role.role');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return back()->withSuccess('Role has been created!');
    }
}
