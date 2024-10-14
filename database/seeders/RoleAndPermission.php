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
            'name' => 'administracion',
        ]);

        $roleteacher = Role::firstOrCreate([
            'name' => 'docente',
        ]);

        Permission::firstOrCreate([
            'name' => 'admin',
        ]);

        Permission::firstOrCreate([
            'name' => 'teacher',
        ]);

        $roleadmin->givePermissionTo('admin');
        $roleteacher->givePermissionTo('teacher');
    }
}

