<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DummyMemberSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 1000; $i++) {
            $phone = substr($faker->phoneNumber, 0, 15); // Limit length to 15
            $uniqueId = time() . '_' . $i;
            
            // Create user
            $user = User::create([
                'name' => 'Dummy Member ' . $i . ' (' . $uniqueId . ')',
                'email' => 'dummy_' . $uniqueId . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'member',
                'phone_number' => $phone,
                'must_change_password' => false,
            ]);

            // Create member detail
            Member::create([
                'user_id' => $user->id,
                'phone_number' => $phone,
                'address' => $faker->address,
                'gender' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'join_date' => Carbon::now()->subDays(rand(1, 60)),
                'expiry_date' => Carbon::now()->addDays(rand(10, 60)),
                'status' => 'active',
            ]);
        }
    }
}
