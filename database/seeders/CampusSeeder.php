<?php

namespace Database\Seeders;

use App\Models\Campus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Campus::updateOrCreate(
            ['id' => 1], // id=1 ফিক্সড রাখার জন্য শর্ত
            [
                'campus_code'    => 'HO-001',
                'name'           => 'Head Office',
                'is_main_campus' => true,
                'campus_number'  => 1,
                'country'        => 'Bangladesh',
                'city'           => 'Dhaka',
                'address'        => 'House #00, Road #00, Dhanmondi, Dhaka-1205',
                'phone'          => '+8801700000000',
                'email'          => 'headoffice@yourdomain.com',
                'logo'           => null, // পরে ড্যাশবোর্ড থেকে আপলোড করা যাবে
                'currency'       => 'BDT',
                'timezone'       => 'Asia/Dhaka',
                'status'         => 'active',
            ]
        );
    }
}
