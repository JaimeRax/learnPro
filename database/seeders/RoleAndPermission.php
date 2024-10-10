<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAndPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleadmin = Role::firstOrCreate([
            'name' => 'admin',
        ]);

        $roleteacher = Role::firstOrCreate([
            'name' => 'teaching',
        ]);

        Permission::firstOrCreate([
            'name' => 'createStudent',
        ]);

        Permission::firstOrCreate([
            'name' => 'editStudent',
        ]);

        Permission::firstOrCreate([
            'name' => 'deleteStudent',
        ]);

        Permission::firstOrCreate([
            'name' => 'seeResources',
        ]);

        Permission::firstOrCreate([
            'name' => 'seePayments',
        ]);

        Permission::firstOrCreate([
            'name' => 'seeAssignments',
        ]);

        Permission::firstOrCreate([
            'name' => 'reportsPayments',
        ]);

        $roleadmin->givePermissionTo('createStudent');
        $roleadmin->givePermissionTo('editStudent');
        $roleadmin->givePermissionTo('deleteStudent');
        $roleadmin->givePermissionTo('seeResources');
        $roleadmin->givePermissionTo('seePayments');
        $roleadmin->givePermissionTo('seeAssignments');
        $roleadmin->givePermissionTo('reportsPayments');
    }
}

