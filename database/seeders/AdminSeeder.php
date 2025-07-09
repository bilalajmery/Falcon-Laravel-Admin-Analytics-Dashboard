<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'uid' => Str::uuid(),
            'name' => 'Admin',
            'email' => 'dummy@example.com',
            'phone' => '03001234567',
            'profile' => 'http://192.168.100.8:2000/assets/img/elearning/avatar/student.png',
            'otp' => null,
            'twoStepVerification' => false,
            'status' => true,
            'password' => Hash::make('Admin@123'),
        ]);
    }
}
