<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::findByName('admin');

        $admin->syncPermissions(Permission::all());

        $editor = Role::findByName('editor');

        $editor->givePermissionTo([
            'view users',
            'view farmers',
            'view crops',
            'view seeds',
            'most visited'
        ]);
    }
}
