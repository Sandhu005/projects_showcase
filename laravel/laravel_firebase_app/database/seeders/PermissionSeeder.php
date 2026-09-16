<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate([
            'name' => 'manage users'
        ]);
        
        Permission::firstOrCreate([
            'name' => 'view users'
        ]);
        
        Permission::firstOrCreate([
            'name' => 'view farmers'
        ]);
        
        Permission::firstOrCreate([
            'name' => 'view crops'
        ]);
        
        Permission::firstOrCreate([
            'name' => 'manage crops'
        ]);
        
        Permission::firstOrCreate([
            'name' => 'view seeds'
        ]);
        
        Permission::firstOrCreate([
            'name' => 'manage seeds'
        ]);
        
        Permission::firstOrCreate([
            'name' => 'most visited'
        ]);
    }
}
