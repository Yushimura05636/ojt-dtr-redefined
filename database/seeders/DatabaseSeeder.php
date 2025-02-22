<?php

namespace Database\Seeders;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use App\Models\Histories;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $authController = app(AuthController::class);

        // Simulate a request with user registration data
        $request = new Request([
            'firstname' => 'admin',
            'lastname' => 'admin',
            'middlename' => 'admin',
            'email' => 'admin@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'admin',
            'phone' => '09123456789',
            'gender' => 'female',
            'address' => 'Test Address',
            'school' => null, // Assuming school ID 1
            'student_no' => '1234567890',
            'emergency_contact_fullname' => 'Test Emergency',
            'emergency_contact_number' => '09123456789',
            'emergency_contact_address' => 'Test Emergency Address',
        ]);

        // Call the register method
        $authController->adminRegister($request, app(FileController::class));

        // Simulate a request with user registration data
        $request = new Request([
            'firstname' => 'Ace',
            'lastname' => 'Benigno',
            'middlename' => 'Perl',
            'email' => 'ace@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'admin',
            'phone' => '091241561753',
            'gender' => 'male',
            'address' => 'R Web EL Rio Davao City',
            'school' => null, // Assuming school ID 1
            'student_no' => '123456781736',
            'emergency_contact_fullname' => 'Test Emergency',
            'emergency_contact_number' => '091234567278',
            'emergency_contact_address' => 'Test Emergency Address',
        ]);

        // Call the register method
        $authController->adminRegister($request, app(FileController::class));
    }
}
