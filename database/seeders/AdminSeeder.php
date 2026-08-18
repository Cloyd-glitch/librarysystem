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
                'middlename' => null,
                'course' => null,
                'year_level' => null,
                'password' => 'StrongestPassword123',
                'role' => 'admin',
                'isActive' => true,
            ]
        );
    }
}