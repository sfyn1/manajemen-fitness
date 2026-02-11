<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun ADMIN (Wajib ada buat login pertama)
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone_number' => '081234567890',
            'must_change_password' => false,
        ]);

        // 2. Buat Akun OWNER (Contoh)
        User::create([
            'name' => 'Bapak Owner',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'phone_number' => '08987654321',
            'must_change_password' => false,
        ]);
    }
}