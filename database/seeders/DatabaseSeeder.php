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

        User::create([
            'firstname' => 'user',
            'lastname' => 'user',
            'middlename' => 'user',
            'email' => 'user@email.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '09123456782',
            'gender' => 'male',
            'address' => 'Test Address',
            'school' => 'Test School',
            'student_no' => '1234567892',
            'starting_date' => '2024-01-01',
            'emergency_contact_fullname' => 'Test Emergency',
            'emergency_contact_number' => '09123456789',
            'emergency_contact_address' => 'Test Emergency Address',
            'qr_code' => 'Test QR Code',
        ]);

        Histories::create([
            'description' => 'time in',
            'datetime' => '2025-02-05 08:48:35',
            'user_id' => 2,
        ]);

        Histories::create([
            'description' => 'time in',
            'datetime' => '2025-02-05 09:48:35',
            'user_id' => 2,
        ]);

        Histories::create([
            'description' => 'time in',
            'datetime' => '2025-02-05 10:48:35',
            'user_id' => 2,
        ]);

        Histories::create([
            'description' => 'time out',
            'datetime' => '2025-02-05 11:48:35',
            'user_id' => 2,
        ]);

        Histories::create([
            'description' => 'time out',
            'datetime' => '2025-02-05 11:58:35',
            'user_id' => 2,
        ]);

        Histories::create([
            'description' => 'time out',
            'datetime' => '2025-02-05 13:50:35',
            'user_id' => 2,
        ]);
        
        Histories::create([
            'description' => 'time out',
            'datetime' => '2025-02-05 15:50:35',
            'user_id' => 2,
        ]);

        Histories::create([
            'description' => 'time in',
            'datetime' => '2025-02-06 8:50:35',
            'user_id' => 2,
        ]);

        Histories::create([
            'description' => 'time in',
            'datetime' => '2025-02-06 12:50:35',
            'user_id' => 2,
        ]);

        Histories::create([
            'description' => 'time out',
            'datetime' => '2025-02-06 15:50:35',
            'user_id' => 2,
        ]);

        Histories::create([
            'description' => 'time out',
            'datetime' => '2025-02-06 20:50:35',
            'user_id' => 2,
        ]);

        Histories::create([
            'description' => 'time in',
            'datetime' => '2025-02-08 8:50:35',
            'user_id' => 2,
        ]);

        Histories::create([
            'description' => 'time in',
            'datetime' => '2025-02-08 10:50:35',
            'user_id' => 2,
        ]);

        Histories::create([
            'description' => 'time in',
            'datetime' => '2025-02-08 12:50:35',
            'user_id' => 2,
        ]);

        Histories::create([
            'description' => 'time out',
            'datetime' => '2025-02-08 13:50:35',
            'user_id' => 2,
        ]);

        Histories::create([
            'description' => 'time out',
            'datetime' => '2025-02-08 15:50:35',
            'user_id' => 2,
        ]);

        Histories::create([
            'description' => 'time out',
            'datetime' => '2025-02-08 16:50:35',
            'user_id' => 2,
        ]);
    }
}
