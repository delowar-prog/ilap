<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use Carbon\Carbon;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $states = [];

        // 1. Bangladesh Divisions
        $bd = Country::where('iso2', 'BD')->first();
        if ($bd) {
            $bdDivisions = ['Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Barisal', 'Sylhet', 'Rangpur', 'Mymensingh'];
            foreach ($bdDivisions as $div) {
                $states[] = [
                    'country_id' => $bd->id,
                    'name' => $div,
                    'state_code' => substr(strtoupper($div), 0, 3),
                    'type' => 'Division',
                    'status' => 'active',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        // 2. UK Regions
        $gb = Country::where('iso2', 'GB')->first();
        if ($gb) {
            $gbRegions = [
                ['name' => 'England', 'type' => 'Country'],
                ['name' => 'Scotland', 'type' => 'Country'],
                ['name' => 'Wales', 'type' => 'Country'],
                ['name' => 'Northern Ireland', 'type' => 'Province'],
            ];
            foreach ($gbRegions as $reg) {
                $states[] = [
                    'country_id' => $gb->id,
                    'name' => $reg['name'],
                    'state_code' => substr(strtoupper($reg['name']), 0, 3),
                    'type' => $reg['type'],
                    'status' => 'active',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        // 3. US States (Sample)
        $us = Country::where('iso2', 'US')->first();
        if ($us) {
            $usStates = [
                ['name' => 'California', 'code' => 'CA'],
                ['name' => 'Texas', 'code' => 'TX'],
                ['name' => 'New York', 'code' => 'NY'],
                ['name' => 'Florida', 'code' => 'FL'],
                ['name' => 'Illinois', 'code' => 'IL'],
            ];
            foreach ($usStates as $st) {
                $states[] = [
                    'country_id' => $us->id,
                    'name' => $st['name'],
                    'state_code' => $st['code'],
                    'type' => 'State',
                    'status' => 'active',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        // 4. Canada Provinces (Sample)
        $ca = Country::where('iso2', 'CA')->first();
        if ($ca) {
            $caProvinces = ['Ontario', 'Quebec', 'British Columbia', 'Alberta'];
            foreach ($caProvinces as $prov) {
                $states[] = [
                    'country_id' => $ca->id,
                    'name' => $prov,
                    'state_code' => substr(strtoupper($prov), 0, 3),
                    'type' => 'Province',
                    'status' => 'active',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('states')->insert($states);
    }
}