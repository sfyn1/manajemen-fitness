<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun ADMIN (Untuk Anda Login nanti)
        User::create([
            'name' => 'Admin Gintung',
            'email' => 'admin@gintung.com',
            'password' => Hash::make('password'), // passwordnya 'password'
            'role' => 'admin',
        ]);

        // 2. Buat Akun OWNER
        User::create([
            'name' => 'Bapak Owner',
            'email' => 'owner@gintung.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);
        
        // 3. Buat Akun PT (Personal Trainer)
        User::create([
            'name' => 'Coach Budi',
            'email' => 'budi@gintung.com',
            'password' => Hash::make('password'),
            'role' => 'pt',
        ]);

        // 4. Buat Akun MEMBER CONTOH
        $memberUser = User::create([
            'name' => 'Sufyan Dzaki', // Nama Anda sebagai contoh member
            'email' => 'sufyan@example.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        // Isi data detail untuk member tersebut
        Member::create([
            'user_id' => $memberUser->id,
            'phone_number' => '081234567890',
            'address' => 'Jl. Gintung No. 1',
            'gender' => 'L',
            'join_date' => now(),
            'expiry_date' => now()->addMonth(), // Aktif 1 bulan
            'status' => 'active',
        ]);
    }
}