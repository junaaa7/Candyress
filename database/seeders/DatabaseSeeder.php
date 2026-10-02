<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@candyress.com'],
            [
                'name' => 'Admin Candyress',
                'username' => 'admin', // <-- Tambahkan username
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'whatsapp' => '081371711181', // <-- Ubah 'phone' menjadi 'whatsapp' menyesuaikan Model User Anda
            ]
        );

        // Buat Akun Customer
        User::updateOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'John Customer',
                'username' => 'customer', // <-- Tambahkan username
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'whatsapp' => '081371711181', // <-- Ubah 'phone' menjadi 'whatsapp' menyesuaikan Model User Anda
            ]
        );
    }
}
