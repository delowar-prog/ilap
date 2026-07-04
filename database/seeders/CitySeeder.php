<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use Carbon\Carbon;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [];

        // Helper function to push city data
        $addCity = function ($countryIso, $stateName, $cityName, $cityCode) use (&$cities) {
            $country = Country::where('iso2', $countryIso)->first();
            $state = State::where('country_id', $country->id ?? 0)->where('name', $stateName)->first();
            
            if ($country && $state) {
                $cities[] = [
                    'country_id' => $country->id,
                    'state_id' => $state->id,
                    'name' => $cityName,
                    'city_code' => $cityCode,
                    'status' => 'active',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        };

        // Bangladesh Cities
        $addCity('BD', 'Dhaka', 'Dhaka', 'DAC');
        $addCity('BD', 'Dhaka', 'Gazipur', 'GAZ');
        $addCity('BD', 'Dhaka', 'Narayanganj', 'NAR');
        $addCity('BD', 'Chittagong', 'Chittagong', 'CGP');
        $addCity('BD', 'Chittagong', "Cox's Bazar", 'CXB');
        $addCity('BD', 'Sylhet', 'Sylhet', 'ZYL');
        $addCity('BD', 'Khulna', 'Khulna', 'KHL');
        $addCity('BD', 'Rajshahi', 'Rajshahi', 'RAJ');

        // UK Cities
        $addCity('GB', 'England', 'London', 'LON');
        $addCity('GB', 'England', 'Manchester', 'MAN');
        $addCity('GB', 'England', 'Birmingham', 'BHX');
        $addCity('GB', 'England', 'Liverpool', 'LIV');
        $addCity('GB', 'Scotland', 'Edinburgh', 'EDI');
        $addCity('GB', 'Scotland', 'Glasgow', 'GLA');

        // US Cities
        $addCity('US', 'California', 'Los Angeles', 'LAX');
        $addCity('US', 'California', 'San Francisco', 'SFO');
        $addCity('US', 'California', 'San Diego', 'SAN');
        $addCity('US', 'New York', 'New York City', 'NYC');
        $addCity('US', 'Texas', 'Houston', 'HOU');
        $addCity('US', 'Texas', 'Dallas', 'DFW');
        $addCity('US', 'Florida', 'Miami', 'MIA');
        $addCity('US', 'Florida', 'Orlando', 'ORL');

        // Canada Cities
        $addCity('CA', 'Ontario', 'Toronto', 'TOR');
        $addCity('CA', 'Ontario', 'Ottawa', 'OTT');
        $addCity('CA', 'Quebec', 'Montreal', 'YMQ');
        $addCity('CA', 'British Columbia', 'Vancouver', 'YVR');
        $addCity('CA', 'Alberta', 'Calgary', 'YYC');

        // Australia Cities
        $addCity('AU', 'New South Wales', 'Sydney', 'SYD'); // Note: Add NSW to states if needed
        $addCity('AU', 'Victoria', 'Melbourne', 'MEL');     // Note: Add VIC to states if needed

        DB::table('cities')->insert($cities);
    }
}