<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@fitappce.com'],
            [
                'name' => 'Administrador FitApp',
                'password' => 'Admin12345',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
