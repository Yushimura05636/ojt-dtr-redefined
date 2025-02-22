<?php

namespace Database\Seeders;

use App\Models\Histories;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'firstname' => 'admin',
            'lastname' => 'admin',
            'middlename' => 'admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '09123456789',
            'gender' => 'male',
            'address' => 'Test Address',
            'school' => 'Test School',
            'student_no' => '1234567890',
            'starting_date' => Carbon::now(),
            'emergency_contact_fullname' => 'Test Emergency',
            'emergency_contact_number' => '09123456789',
            'emergency_contact_address' => 'Test Emergency Address',
            'qr_code' => 'Test QR Code',
        ]);
    }
}
