<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{State, Country};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class StateSeeder extends Seeder
{
    /**
     * Seed the states table with provinces/states for multiple countries.
     */
    public function run()
    {
        // Fetch all countries once and create a lookup array by code
        $countries = Country::pluck('uid', 'code')->toArray();

        $states = [
            // Pakistan
            ['name' => 'Punjab', 'code' => 'PB', 'countryCode' => 'PK'],
            ['name' => 'Sindh', 'code' => 'SD', 'countryCode' => 'PK'],
            ['name' => 'Khyber Pakhtunkhwa', 'code' => 'KP', 'countryCode' => 'PK'],
            ['name' => 'Balochistan', 'code' => 'BL', 'countryCode' => 'PK'],
            ['name' => 'Islamabad Capital Territory', 'code' => 'ICT', 'countryCode' => 'PK'],
            ['name' => 'Azad Jammu and Kashmir', 'code' => 'AJK', 'countryCode' => 'PK'],
            ['name' => 'Gilgit-Baltistan', 'code' => 'GB', 'countryCode' => 'PK'],
            // United States (sample)
            ['name' => 'California', 'code' => 'CA', 'countryCode' => 'US'],
            ['name' => 'Texas', 'code' => 'TX', 'countryCode' => 'US'],
            ['name' => 'New York', 'code' => 'NY', 'countryCode' => 'US'],
            ['name' => 'Florida', 'code' => 'FL', 'countryCode' => 'US'],
            ['name' => 'Illinois', 'code' => 'IL', 'countryCode' => 'US'],
            // India (sample)
            ['name' => 'Maharashtra', 'code' => 'MH', 'countryCode' => 'IN'],
            ['name' => 'Delhi', 'code' => 'DL', 'countryCode' => 'IN'],
            ['name' => 'Karnataka', 'code' => 'KA', 'countryCode' => 'IN'],
            ['name' => 'Tamil Nadu', 'code' => 'TN', 'countryCode' => 'IN'],
            ['name' => 'Uttar Pradesh', 'code' => 'UP', 'countryCode' => 'IN'],
        ];

        $insertData = [];
        foreach ($states as $state) {
            // Check if country exists
            if (!isset($countries[$state['countryCode']])) {
                Log::warning("Country with code {$state['countryCode']} not found for state {$state['name']}");
                continue;
            }

            $insertData[] = [
                'uid' => (string) Str::uuid(),
                'name' => $state['name'],
                'code' => $state['code'],
                'countryId' => $countries[$state['countryCode']],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Bulk insert for efficiency
        if (!empty($insertData)) {
            State::insert($insertData);
        }
    }
}
