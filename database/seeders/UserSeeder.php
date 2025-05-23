<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@sipakar.com',
            'password' => Hash::make('secret123'),
        ]);

        $user1->assignRole('superadmin');

        $user2 = User::create([
            'name' => 'Admin Pendaftaran',
            'email' => 'pendaftaran@sipakar.com',
            'password' => Hash::make('secret123'),
        ]);

        $user2->assignRole('registration');

        $user3 = User::create([
            'name' => 'Dokter',
            'email' => 'dokter@sipakar.com',
            'password' => Hash::make('secret123'),
        ]);

        $user3->assignRole('doctor');

        $user4 = User::create([
            'name' => 'Perawat',
            'email' => 'perawat@sipakar.com',
            'password' => Hash::make('secret123'),
        ]);

        $user4->assignRole('nurse');

        $user5 = User::create([
            'name' => 'Apoteker',
            'email' => 'apoteker@sipakar.com',
            'password' => Hash::make('secret123'),
        ]);

        $user5->assignRole('pharmacist');
    }
}