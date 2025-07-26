<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;
use Illuminate\Support\Str;

class StateSeeder extends Seeder
{
    /**
     * Seed the states table with Pakistan's provinces and territories.
     */
    public function run()
    {
        $states = [
            ['name' => 'Punjab', 'code' => 'PB'],
            ['name' => 'Sindh', 'code' => 'SD'],
            ['name' => 'Khyber Pakhtunkhwa', 'code' => 'KP'],
            ['name' => 'Balochistan', 'code' => 'BL'],
            ['name' => 'Islamabad Capital Territory', 'code' => 'ICT'],
            ['name' => 'Azad Jammu and Kashmir', 'code' => 'AJK'],
            ['name' => 'Gilgit-Baltistan', 'code' => 'GB'],
        ];

        foreach ($states as $state) {
            State::create([
                'uid' => Str::uuid(),
                'name' => $state['name'],
                'code' => $state['code'],
            ]);
        }
    }
}
