<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id_level' => 1, // Admin
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin123',
        ]);

        User::create([
            'id_level' => 2,
            'name' => 'Pimpinan',
            'email' => 'pimpinan@gmail.com',
            'password' => 'pimpinan123',
        ]);

        User::create([
            'id_level' => 3,
            'name' => 'Operator',
            'email' => 'operator@gmail.com',
            'password' => 'operator123',
        ]);
    }
}
