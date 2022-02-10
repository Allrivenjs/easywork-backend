<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Student']);
        $role2 = Role::create(['name' => 'Worker']);

        Permission::create(['name' => 'role.list',
            'description' => 'Ver lista de roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'role.edit',
            'description' => 'Actualizar roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'role.delete',
            'description' => 'Eliminar permisos de rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'role.add',
            'description' => 'Agregar rol'])->syncRoles([$role1]);

    }
}
