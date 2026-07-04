<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            [
                'name' => 'Bangladesh',
                'iso2' => 'BD',
                'iso3' => 'BGD',
                'phone_code' => '+880',
                'currency' => 'BDT',
                'currency_symbol' => '৳',
                'capital' => 'Dhaka',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'United Kingdom',
                'iso2' => 'GB',
                'iso3' => 'GBR',
                'phone_code' => '+44',
                'currency' => 'GBP',
                'currency_symbol' => '£',
                'capital' => 'London',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'United States',
                'iso2' => 'US',
                'iso3' => 'USA',
                'phone_code' => '+1',
                'currency' => 'USD',
                'currency_symbol' => '$',
                'capital' => 'Washington, D.C.',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Canada',
                'iso2' => 'CA',
                'iso3' => 'CAN',
                'phone_code' => '+1',
                'currency' => 'CAD',
                'currency_symbol' => '$',
                'capital' => 'Ottawa',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Australia',
                'iso2' => 'AU',
                'iso3' => 'AUS',
                'phone_code' => '+61',
                'currency' => 'AUD',
                'currency_symbol' => '$',
                'capital' => 'Canberra',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'India',
                'iso2' => 'IN',
                'iso3' => 'IND',
                'phone_code' => '+91',
                'currency' => 'INR',
                'currency_symbol' => '₹',
                'capital' => 'New Delhi',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Malaysia',
                'iso2' => 'MY',
                'iso3' => 'MYS',
                'phone_code' => '+60',
                'currency' => 'MYR',
                'currency_symbol' => 'RM',
                'capital' => 'Kuala Lumpur',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('countries')->insert($countries);
    }
}