<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
//use GiveP2P\P2P\View;
use App\Models\Role;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $users = User::with('role')->paginate(20);
        return view('user.user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

                $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
            ]);

            event(new Registered($user));

            return redirect()->route('user.create')
                ->with('message', 'User created successfully!')
                ->with('type', 'success');

        } catch (ValidationException $e) {

            return back()->withErrors($e->validator->errors())
                ->withInput($request->input());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
//    public function update(Request $request, User $user): RedirectResponse
//    {
//        $request->validate([
//            'name' => ['required', 'string', 'max:255'],
//        ]);
//
//        if ($request->has('name')) {
//            $user->name = $request->name;
//        }
//
//        $user->fill($request->except('email'));
//
//        if ($request->filled('password')) {
//            if( $user->password === $request->password ){
//                $user->password = $request->password;
//            } else {
//                $user->password = Hash::make($request->password);
//            }
//        }
//
//        if ($request->has('role_id')) {
//            $user->role_id = $request->role_id;
//        }
//
//        $user->save();
//
//        return redirect()->route('user')
//            ->with('message', 'User updated successfully!')
//            ->with('type', 'success');
//    }

    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:8',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user's email if it has changed
        if ($validatedData['email'] !== $user->email) {
            $user->email = $validatedData['email'];
        }

        // Update the user's password if provided
        if (isset($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        if ($request->has('role_id')) {
            $user->role_id = $request->role_id;
        }

        // Save the updated user
        $user->save();

        return redirect()->route('user')
            ->with('message', 'User updated successfully!')
            ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $role = User::findOrFail($id);
        $role->delete();

        return redirect()->route('user')->with('success', 'User deleted successfully!');
    }
}
