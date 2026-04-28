<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear o recuperar Permisos
        $pVerUsuarios      = Permission::firstOrCreate(['name' => 'ver usuarios']);
        $pCrearUsuarios    = Permission::firstOrCreate(['name' => 'crear usuarios']);
        $pEditarUsuarios   = Permission::firstOrCreate(['name' => 'editar usuarios']);
        $pEliminarUsuarios = Permission::firstOrCreate(['name' => 'eliminar usuarios']);

        // 2. Crear o recuperar Roles
        $roleAdmin    = Role::firstOrCreate(['name' => 'admin']);
        $roleCliente  = Role::firstOrCreate(['name' => 'cliente']);
        $roleEmpleado = Role::firstOrCreate(['name' => 'empleado']);

        // 3. Asignar Permisos a los Roles
        // El Admin tiene acceso total
        $roleAdmin->syncPermissions([
            $pVerUsuarios,
            $pCrearUsuarios,
            $pEditarUsuarios,
            $pEliminarUsuarios
        ]);

        // El Empleado tiene acceso limitado
        $roleEmpleado->syncPermissions([
            $pVerUsuarios,
            $pEditarUsuarios
        ]);

        // 4. Crear o actualizar el Usuario Administrador
        // updateOrCreate devuelve el objeto del usuario directamente
        $user = User::updateOrCreate(
            ['email' => 'admin@ejemplo.com'], // Identificador único
            [
                'name'     => 'Admin Test',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(), // Opcional: marcar como verificado
            ]
        );

        // 5. Asignar el Rol al Usuario
        // syncRoles es mejor porque evita duplicados en la tabla model_has_roles
        $user->syncRoles($roleAdmin);

    }
}
