<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin Default
        User::create([
            'name' => 'Admin e-Layanan Desa',
            'email' => 'admin@steamtek.id',
            'password' => Hash::make('password123'),
            'role' => 'admin', // Role diset sebagai admin
        ]);
        $this->call(LaporanSeeder::class);
    }
    
}