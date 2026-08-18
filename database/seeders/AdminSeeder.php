<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@librarysystem.com'],
            [
                'student_id' => 'admin@library.com',
                'firstname' => 'System',
                'lastname' => 'Admin',
                'middlename' => 'N/A',
                'course' => 'N/A',
                'year_level' => 0,
                'password' => 'StrongestPassword123',
                'role' => 'admin',
                'isActive' => true,
            ]
        );
    }
}