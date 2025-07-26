<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    /**
     * Seed the cities table with major cities from Pakistan's provinces and territories.
     */
    public function run()
    {
        $cities = [
            // Punjab
            ['name' => 'Lahore', 'state_code' => 'PB'],
            ['name' => 'Faisalabad', 'state_code' => 'PB'],
            ['name' => 'Rawalpindi', 'state_code' => 'PB'],
            ['name' => 'Multan', 'state_code' => 'PB'],
            ['name' => 'Gujranwala', 'state_code' => 'PB'],
            ['name' => 'Sialkot', 'state_code' => 'PB'],
            ['name' => 'Bahawalpur', 'state_code' => 'PB'],
            ['name' => 'Sargodha', 'state_code' => 'PB'],
            ['name' => 'Sheikhupura', 'state_code' => 'PB'],
            ['name' => 'Rahim Yar Khan', 'state_code' => 'PB'],

            // Sindh
            ['name' => 'Karachi', 'state_code' => 'SD'],
            ['name' => 'Hyderabad', 'state_code' => 'SD'],
            ['name' => 'Sukkur', 'state_code' => 'SD'],
            ['name' => 'Larkana', 'state_code' => 'SD'],
            ['name' => 'Nawabshah', 'state_code' => 'SD'],
            ['name' => 'Mirpur Khas', 'state_code' => 'SD'],
            ['name' => 'Shikarpur', 'state_code' => 'SD'],
            ['name' => 'Jacobabad', 'state_code' => 'SD'],
            ['name' => 'Thatta', 'state_code' => 'SD'],
            ['name' => 'Badin', 'state_code' => 'SD'],
            ['name' => 'Tando Allahyar', 'state_code' => 'SD'],
            ['name' => 'Tando Muhammad Khan', 'state_code' => 'SD'],
            ['name' => 'Khairpur', 'state_code' => 'SD'],
            ['name' => 'Dadu', 'state_code' => 'SD'],
            ['name' => 'Sanghar', 'state_code' => 'SD'],
            ['name' => 'Jamshoro', 'state_code' => 'SD'],
            ['name' => 'Umerkot', 'state_code' => 'SD'],
            ['name' => 'Ghotki', 'state_code' => 'SD'],
            ['name' => 'Kashmore', 'state_code' => 'SD'],
            ['name' => 'Matiari', 'state_code' => 'SD'],
            ['name' => 'Naushahro Feroze', 'state_code' => 'SD'],
            ['name' => 'Qambar Shahdadkot', 'state_code' => 'SD'],
            ['name' => 'Mithi', 'state_code' => 'SD'],
            ['name' => 'Sajawal', 'state_code' => 'SD'],
            ['name' => 'Tando Adam', 'state_code' => 'SD'],
            ['name' => 'Sehwan', 'state_code' => 'SD'],
            ['name' => 'Kotri', 'state_code' => 'SD'],
            ['name' => 'Rohri', 'state_code' => 'SD'],
            ['name' => 'Daharki', 'state_code' => 'SD'],
            ['name' => 'Kandhkot', 'state_code' => 'SD'],
            ['name' => 'Hala', 'state_code' => 'SD'],
            ['name' => 'Mehar', 'state_code' => 'SD'],
            ['name' => 'Shahdadpur', 'state_code' => 'SD'],
            ['name' => 'Khairpur Nathan Shah', 'state_code' => 'SD'],
            ['name' => 'Tando Jam', 'state_code' => 'SD'],
            ['name' => 'Pano Aqil', 'state_code' => 'SD'],
            ['name' => 'Khipro', 'state_code' => 'SD'],
            ['name' => 'Moro', 'state_code' => 'SD'],
            ['name' => 'Sujawal', 'state_code' => 'SD'],
            ['name' => 'Tando Ghulam Ali', 'state_code' => 'SD'],
            ['name' => 'Digri', 'state_code' => 'SD'],
            ['name' => 'Kunri', 'state_code' => 'SD'],
            ['name' => 'Chachro', 'state_code' => 'SD'],
            ['name' => 'Nagarparkar', 'state_code' => 'SD'],
            ['name' => 'Diplo', 'state_code' => 'SD'],
            ['name' => 'Islamkot', 'state_code' => 'SD'],
            ['name' => 'Jhudo', 'state_code' => 'SD'],
            ['name' => 'Samaro', 'state_code' => 'SD'],
            ['name' => 'Pithoro', 'state_code' => 'SD'],
            ['name' => 'Tando Bago', 'state_code' => 'SD'],
            ['name' => 'Talhar', 'state_code' => 'SD'],
            ['name' => 'Jati', 'state_code' => 'SD'],
            ['name' => 'Mirpur Sakro', 'state_code' => 'SD'],
            ['name' => 'Ghorabari', 'state_code' => 'SD'],
            ['name' => 'Keti Bandar', 'state_code' => 'SD'],
            ['name' => 'Khairpur Mirs', 'state_code' => 'SD'],
            ['name' => 'Gambat', 'state_code' => 'SD'],
            ['name' => 'Sobhodero', 'state_code' => 'SD'],
            ['name' => 'Ranipur', 'state_code' => 'SD'],
            ['name' => 'Thul', 'state_code' => 'SD'],
            ['name' => 'Garhi Khairo', 'state_code' => 'SD'],
            ['name' => 'Ratodero', 'state_code' => 'SD'],
            ['name' => 'Dokri', 'state_code' => 'SD'],
            ['name' => 'Naudero', 'state_code' => 'SD'],
            ['name' => 'Bhirkan', 'state_code' => 'SD'],
            ['name' => 'Kandiaro', 'state_code' => 'SD'],
            ['name' => 'Bhit Shah', 'state_code' => 'SD'],
            ['name' => 'Sakrand', 'state_code' => 'SD'],
            ['name' => 'Tando Yousuf', 'state_code' => 'SD'],
            ['name' => 'Shahpur Chakar', 'state_code' => 'SD'],
            ['name' => 'Sinjhoro', 'state_code' => 'SD'],
            ['name' => 'Jhol', 'state_code' => 'SD'],
            ['name' => 'Khudian', 'state_code' => 'SD'],
            ['name' => 'Daur', 'state_code' => 'SD'],
            ['name' => 'Mehrabpur', 'state_code' => 'SD'],
            ['name' => 'Mirwah Gorchani', 'state_code' => 'SD'],
            ['name' => 'Madeji', 'state_code' => 'SD'],
            ['name' => 'Garhi Yasin', 'state_code' => 'SD'],
            ['name' => 'Khanpur', 'state_code' => 'SD'],
            ['name' => 'Shikarpur City', 'state_code' => 'SD'],
            ['name' => 'Lakhi', 'state_code' => 'SD'],
            ['name' => 'Ubauro', 'state_code' => 'SD'],
            ['name' => 'Mirpur Mathelo', 'state_code' => 'SD'],
            ['name' => 'Khan Bela', 'state_code' => 'SD'],
            ['name' => 'Tando Masti Khan', 'state_code' => 'SD'],
            ['name' => 'Hingorja', 'state_code' => 'SD'],
            ['name' => 'Kot Diji', 'state_code' => 'SD'],
            ['name' => 'Faqirabad', 'state_code' => 'SD'],
            ['name' => 'Kumb', 'state_code' => 'SD'],
            ['name' => 'Kingri', 'state_code' => 'SD'],
            ['name' => 'Thari Mirwah', 'state_code' => 'SD'],
            ['name' => 'Pirjo Goth', 'state_code' => 'SD'],
            ['name' => 'Sann', 'state_code' => 'SD'],
            ['name' => 'Johi', 'state_code' => 'SD'],
            ['name' => 'Bhan Saeedabad', 'state_code' => 'SD'],
            ['name' => 'Darbelo', 'state_code' => 'SD'],
            ['name' => 'Chuhar Jamali', 'state_code' => 'SD'],
            ['name' => 'Bulri Shah Karim', 'state_code' => 'SD'],
            ['name' => 'Matli', 'state_code' => 'SD'],
            ['name' => 'Daro', 'state_code' => 'SD'],
            // Khyber Pakhtunkhwa
            ['name' => 'Peshawar', 'state_code' => 'KP'],
            ['name' => 'Mardan', 'state_code' => 'KP'],
            ['name' => 'Abbottabad', 'state_code' => 'KP'],
            ['name' => 'Mingora', 'state_code' => 'KP'],
            ['name' => 'Kohat', 'state_code' => 'KP'],
            ['name' => 'Bannu', 'state_code' => 'KP'],
            ['name' => 'Dera Ismail Khan', 'state_code' => 'KP'],
            ['name' => 'Mansehra', 'state_code' => 'KP'],
            // Balochistan
            ['name' => 'Quetta', 'state_code' => 'BL'],
            ['name' => 'Gwadar', 'state_code' => 'BL'],
            ['name' => 'Turbat', 'state_code' => 'BL'],
            ['name' => 'Sibi', 'state_code' => 'BL'],
            ['name' => 'Chaman', 'state_code' => 'BL'],
            ['name' => 'Zhob', 'state_code' => 'BL'],
            ['name' => 'Khuzdar', 'state_code' => 'BL'],
            // Islamabad Capital Territory
            ['name' => 'Islamabad', 'state_code' => 'ICT'],
            // Azad Jammu and Kashmir
            ['name' => 'Muzaffarabad', 'state_code' => 'AJK'],
            ['name' => 'Mirpur', 'state_code' => 'AJK'],
            ['name' => 'Rawalakot', 'state_code' => 'AJK'],
            ['name' => 'Bagh', 'state_code' => 'AJK'],
            ['name' => 'Kotli', 'state_code' => 'AJK'],
            // Gilgit-Baltistan
            ['name' => 'Gilgit', 'state_code' => 'GB'],
            ['name' => 'Skardu', 'state_code' => 'GB'],
            ['name' => 'Chilas', 'state_code' => 'GB'],
            ['name' => 'Khaplu', 'state_code' => 'GB'],
        ];

        foreach ($cities as $city) {
            $state = State::where('code', $city['state_code'])->first();
            City::create([
                'uid' => Str::uuid(),
                'name' => $city['name'],
                'stateId' => $state->uid,
            ]);
        }
    }
}
