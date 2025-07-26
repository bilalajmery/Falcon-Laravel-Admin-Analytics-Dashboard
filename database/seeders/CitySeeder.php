<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CitySeeder extends Seeder
{
    /**
     * Seed the cities table with major cities from multiple countries.
     */
    public function run()
    {
        // Fetch all countries and states once for lookup
        $countries = Country::pluck('uid', 'code')->toArray();
        $states = State::pluck('uid', 'code')->toArray();

        $cities = [
            // Pakistan - Punjab (PB)
            ['name' => 'Lahore', 'state_code' => 'PB', 'country_code' => 'PK'],
            ['name' => 'Faisalabad', 'state_code' => 'PB', 'country_code' => 'PK'],
            ['name' => 'Rawalpindi', 'state_code' => 'PB', 'country_code' => 'PK'],
            ['name' => 'Multan', 'state_code' => 'PB', 'country_code' => 'PK'],
            ['name' => 'Gujranwala', 'state_code' => 'PB', 'country_code' => 'PK'],
            ['name' => 'Sialkot', 'state_code' => 'PB', 'country_code' => 'PK'],
            ['name' => 'Bahawalpur', 'state_code' => 'PB', 'country_code' => 'PK'],
            ['name' => 'Sargodha', 'state_code' => 'PB', 'country_code' => 'PK'],
            ['name' => 'Sheikhupura', 'state_code' => 'PB', 'country_code' => 'PK'],
            ['name' => 'Rahim Yar Khan', 'state_code' => 'PB', 'country_code' => 'PK'],
            // Pakistan - Sindh (SD)
            ['name' => 'Karachi', 'state_code' => 'SD', 'country_code' => 'PK'],
            ['name' => 'Hyderabad', 'state_code' => 'SD', 'country_code' => 'PK'],
            ['name' => 'Sukkur', 'state_code' => 'SD', 'country_code' => 'PK'],
            ['name' => 'Larkana', 'state_code' => 'SD', 'country_code' => 'PK'],
            ['name' => 'Nawabshah', 'state_code' => 'SD', 'country_code' => 'PK'],
            ['name' => 'Mirpur Khas', 'state_code' => 'SD', 'country_code' => 'PK'],
            ['name' => 'Shikarpur', 'state_code' => 'SD', 'country_code' => 'PK'],
            ['name' => 'Jacobabad', 'state_code' => 'SD', 'country_code' => 'PK'],
            ['name' => 'Thatta', 'state_code' => 'SD', 'country_code' => 'PK'],
            ['name' => 'Badin', 'state_code' => 'SD', 'country_code' => 'PK'],
            // Pakistan - Khyber Pakhtunkhwa (KP)
            ['name' => 'Peshawar', 'state_code' => 'KP', 'country_code' => 'PK'],
            ['name' => 'Mardan', 'state_code' => 'KP', 'country_code' => 'PK'],
            ['name' => 'Abbottabad', 'state_code' => 'KP', 'country_code' => 'PK'],
            ['name' => 'Mingora', 'state_code' => 'KP', 'country_code' => 'PK'],
            ['name' => 'Kohat', 'state_code' => 'KP', 'country_code' => 'PK'],
            // Pakistan - Balochistan (BL)
            ['name' => 'Quetta', 'state_code' => 'BL', 'country_code' => 'PK'],
            ['name' => 'Gwadar', 'state_code' => 'BL', 'country_code' => 'PK'],
            ['name' => 'Turbat', 'state_code' => 'BL', 'country_code' => 'PK'],
            ['name' => 'Sibi', 'state_code' => 'BL', 'country_code' => 'PK'],
            ['name' => 'Chaman', 'state_code' => 'BL', 'country_code' => 'PK'],
            // Pakistan - Islamabad Capital Territory (ICT)
            ['name' => 'Islamabad', 'state_code' => 'ICT', 'country_code' => 'PK'],
            // Pakistan - Azad Jammu and Kashmir (AJK)
            ['name' => 'Muzaffarabad', 'state_code' => 'AJK', 'country_code' => 'PK'],
            ['name' => 'Mirpur', 'state_code' => 'AJK', 'country_code' => 'PK'],
            ['name' => 'Rawalakot', 'state_code' => 'AJK', 'country_code' => 'PK'],
            // Pakistan - Gilgit-Baltistan (GB)
            ['name' => 'Gilgit', 'state_code' => 'GB', 'country_code' => 'PK'],
            ['name' => 'Skardu', 'state_code' => 'GB', 'country_code' => 'PK'],
            // United States - California (CA)
            ['name' => 'Los Angeles', 'state_code' => 'CA', 'country_code' => 'US'],
            ['name' => 'San Francisco', 'state_code' => 'CA', 'country_code' => 'US'],
            ['name' => 'San Diego', 'state_code' => 'CA', 'country_code' => 'US'],
            ['name' => 'Sacramento', 'state_code' => 'CA', 'country_code' => 'US'],
            // United States - Texas (TX)
            ['name' => 'Houston', 'state_code' => 'TX', 'country_code' => 'US'],
            ['name' => 'Austin', 'state_code' => 'TX', 'country_code' => 'US'],
            ['name' => 'Dallas', 'state_code' => 'TX', 'country_code' => 'US'],
            // United States - New York (NY)
            ['name' => 'New York City', 'state_code' => 'NY', 'country_code' => 'US'],
            ['name' => 'Buffalo', 'state_code' => 'NY', 'country_code' => 'US'],
            // India - Maharashtra (MH)
            ['name' => 'Mumbai', 'state_code' => 'MH', 'country_code' => 'IN'],
            ['name' => 'Pune', 'state_code' => 'MH', 'country_code' => 'IN'],
            ['name' => 'Nagpur', 'state_code' => 'MH', 'country_code' => 'IN'],
            // India - Delhi (DL)
            ['name' => 'New Delhi', 'state_code' => 'DL', 'country_code' => 'IN'],
            ['name' => 'Delhi', 'state_code' => 'DL', 'country_code' => 'IN'],
            // India - Karnataka (KA)
            ['name' => 'Bengaluru', 'state_code' => 'KA', 'country_code' => 'IN'],
            ['name' => 'Mysuru', 'state_code' => 'KA', 'country_code' => 'IN'],
        ];

        $insertData = [];
        foreach ($cities as $city) {
            // Check if state and country exist
            if (!isset($states[$city['state_code']])) {
                Log::warning("State with code {$city['state_code']} not found for city {$city['name']}");
                continue;
            }
            if (!isset($countries[$city['country_code']])) {
                Log::warning("Country with code {$city['country_code']} not found for city {$city['name']}");
                continue;
            }

            $insertData[] = [
                'uid' => (string) Str::uuid(),
                'name' => $city['name'],
                'stateId' => $states[$city['state_code']],
                'countryId' => $countries[$city['country_code']],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Bulk insert for efficiency
        if (!empty($insertData)) {
            City::insert($insertData);
        }
    }
}
