<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
{
    User::where('email', 'admin@example.com')->delete();
    User::where('email', 'lerra.nesterchuk@yandex.ru')->delete();

    User::create([
        'name' => 'Администратор',
        'email' => 'admin@bk.ru',
        'phone' => '89080703342',
        'password' => Hash::make('admin123'),
        'role' => 'admin',
    ]);

    User::create([
        'name' => 'Лера',
        'email' => 'lerra.nesterchuk@yandex.ru',
        'phone' => '89087000265',
        'password' => Hash::make('user123'),
        'role' => 'user',
    ]);
}
}