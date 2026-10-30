<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@puskesmaskamal.local'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
        );

        User::updateOrCreate(
            ['email' => 'petugas@puskesmaskamal.local'],
            [
                'name' => 'Petugas Puskesmas',
                'password' => Hash::make('password'),
                'role' => 'petugas',
            ],
        );
    }
}
