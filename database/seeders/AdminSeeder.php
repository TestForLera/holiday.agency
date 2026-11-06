<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'  => 'Администратор',
                'phone' => '+79000000000',
                'password' => Hash::make('password123'),
                'role'  => 'admin',
            ]
        );
    }
}
