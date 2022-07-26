<?php

namespace Database\Seeders;

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
        $role1 = Role::create(['name' => 'admin']);
        $role5 = Role::create(['name' => 'moderator']);
        $role3 = Role::create(['name' => 'professor']);
        $role2 = Role::create(['name' => 'worker']);
        $role4 = Role::create(['name' => 'student']);

        Permission::create([
            'guard_name' => 'api',
            'name' => 'role.list',
            'description' => 'Show list roles', ])->syncRoles([$role1]);
        Permission::create([
            'guard_name' => 'api',
            'name' => 'role.edit',
            'description' => 'Update roles', ])->syncRoles([$role1]);
        Permission::create([
            'guard_name' => 'api',
            'name' => 'role.delete',
            'description' => 'Deleted permission role', ])->syncRoles([$role1]);
        Permission::create([
            'guard_name' => 'api',
            'name' => 'role.add',
            'description' => 'Create role', ])->syncRoles([$role1]);

        Permission::create([
            'guard_name' => 'api',
            'name' => 'coursesAdmin.course',
            'description' => 'Total control on courses', ])->syncRoles([$role1, $role3]);

        Permission::create([
            'guard_name' => 'api',
            'name' => 'taskAdmin.task',
            'description' => 'Total control on task, status and topic', ])->syncRoles([$role1, $role5]);

//        Permission::create(['name' => 'role.add',
//            'description' => 'Agregar rol'])->syncRoles([$role1]);
    }
}
