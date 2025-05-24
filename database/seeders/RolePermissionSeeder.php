<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['superadmin', 'registration', 'doctor', 'nurse', 'pharmacist'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        $permissions = [
            'registration',
            'vital_sign',
            'diagnose',
            'order',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        Role::findByName('superadmin')->givePermissionTo(Permission::all());
        Role::findByName('registration')->givePermissionTo('registration');
        Role::findByName('doctor')->givePermissionTo('diagnose');
        Role::findByName('nurse')->givePermissionTo('vital_sign');
        Role::findByName('pharmacist')->givePermissionTo('order');
    }
}
