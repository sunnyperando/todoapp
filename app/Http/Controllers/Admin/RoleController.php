<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:50', 'unique:roles,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['name'] = strtolower(str_replace(' ', '_', $validated['name']));

        Role::create($validated);

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function show(Role $role)
    {
        $role->load('users');
        $allUsers = User::orderBy('name')->get();

        return view('admin.roles.show', compact('role', 'allUsers'));
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:50', 'unique:roles,name,' . $role->id],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['name'] = strtolower(str_replace(' ', '_', $validated['name']));

        $role->update($validated);

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id'],
        ]);

        $user->roles()->sync($request->input('roles', []));

        return redirect()->back()
            ->with('success', 'Roles updated for ' . $user->name);
    }
}