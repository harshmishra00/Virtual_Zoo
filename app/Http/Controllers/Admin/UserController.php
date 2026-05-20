<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderByDesc('created_at')->paginate(20);
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function assignRole(User $user, Request $request)
    {
        $request->validate(['role' => 'required|exists:roles,name']);
        $user->syncRoles([$request->role]);
        $user->update(['role' => $request->role]);
        return back()->with('success', "Role '{$request->role}' assigned to {$user->name}.");
    }
}
