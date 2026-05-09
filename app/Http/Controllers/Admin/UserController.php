<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $users = $query->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:officer,admin',
            'position' => 'nullable|string|max:255',
        ]);

        $validated['password']  = bcrypt($validated['password']);
        $validated['is_active'] = true;

        $user = User::create($validated);

        event(new Registered($user));

        return redirect()->route('admin.users.index')->with('success', 'Account created. A verification email has been sent.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => "required|email|unique:users,email,{$user->id}",
            'role'     => 'required|in:student,officer,admin',
            'position' => 'nullable|string|max:255',
        ]);

        if ($user->is_protected) {
            unset($validated['role']);
        }

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        if ($user->is_protected) {
            return back()->with('error', 'This account is protected and cannot be removed.');
        }
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Cannot remove your own account.');
        }
        $user->update(['is_active' => false]);
        return back()->with('success', 'Account disabled.');
    }

    public function updateRole(Request $request, User $user)
    {
        if ($user->is_protected) {
            return back()->with('error', 'Cannot change the role of a protected account.');
        }
        $request->validate(['role' => 'required|in:student,officer,admin']);
        $user->update(['role' => $request->role]);
        return back()->with('success', "Role updated to {$request->role}.");
    }

    public function toggleActive(User $user)
    {
        if ($user->is_protected) {
            return back()->with('error', 'Cannot change the status of a protected account.');
        }
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Cannot deactivate your own account.');
        }
        $user->update(['is_active' => ! $user->is_active]);
        return back()->with('success', $user->fresh()->is_active ? 'Account activated.' : 'Account deactivated.');
    }
}
