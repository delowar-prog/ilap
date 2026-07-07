<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
         
             public function run(): void
    {
        $user = User::create([
            'user_first_name' => 'Super',
            'user_middle_name' => 'Admin',
            'user_last_name' => 'Admin',
            'email' => 'superadmin@gmail.com',
            'phone' => '1234567890',
            'password' => Hash::make('12345678'),
            'campus_id' => 1,
        ]);

        $user->assignRole('Super Admin');
    }
}
