<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name' => 'Admin SIPETA',
            'email' => 'admin@sipeta.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'is_tracking' => false,
        ]);

        User::create([
            'id' => 2,
            'name' => 'Petugas Lubuk Pakam',
            'email' => 'lubukpakam@sipeta.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'is_tracking' => false,
        ]);

        User::create([
            'id' => 3,
            'name' => 'Petugas Tanjung Morawa',
            'email' => 'tanjungmorawa@sipeta.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'is_tracking' => true, // dummy langsung aktif
        ]);

        User::create([
            'id' => 4,
            'name' => 'Petugas Percut Sei Tuan',
            'email' => 'percut@sipeta.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'is_tracking' => true, // dummy langsung aktif
        ]);

        User::create([
            'id' => 5,
            'name' => 'Petugas Pancur Batu',
            'email' => 'pancurbatu@sipeta.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'is_tracking' => true, // dummy langsung aktif
        ]);
    }
}
