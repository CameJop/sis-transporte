<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('can:ver usuarios', only: ['index', 'show']),
            new Middleware('can:crear usuarios', only: ['store']),
            new Middleware('can:editar usuarios', only: ['update']),
            new Middleware('can:eliminar usuarios', only: ['destroy']),
        ];
    }

    public function index()
    {
        $users = User::with(['roles:id,name', 'permissions:id,name'])
            ->orderBy('id', 'desc')
            ->get(['id', 'name', 'email', 'created_at']);

        return inertia('Users/Index', [
            'users'       => $users,
            'roles'       => Role::all(['id', 'name']),
            'permissions' => Permission::all(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|exists:roles,name',
            'user_permissions' => 'nullable|array',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole($data['role']);

        if (!empty($data['user_permissions'])) {
            $user->givePermissionTo($data['user_permissions']);
        }

        return redirect()->route('users.index');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role'  => 'required|exists:roles,name',
            'user_permissions' => 'nullable|array',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        $user->syncRoles($data['role']);

        $user->syncPermissions($data['user_permissions'] ?? []);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
