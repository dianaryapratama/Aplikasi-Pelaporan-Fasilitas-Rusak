<?php

namespace Database\Seeders;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat beberapa User/Masyarakat dummy dulu agar relasinya tidak error
        $user1 = User::create(['name' => 'Warga Satu', 'email' => 'warga1@mail.com', 'password' => Hash::make('password'), 'role' => 'user']);
        $user2 = User::create(['name' => 'Warga Dua', 'email' => 'warga2@mail.com', 'password' => Hash::make('password'), 'role' => 'user']);

        // 2. Masukkan data laporan
        Laporan::create([
            'id_user' => $user1->id,
            'nama_fasilitas' => 'Jalan',
            'jenis_kerusakan' => 'Berlubang',
            'deskripsi' => 'Jalan Berlubang dan banyak genangan belum di aspal',
            'status' => 'Proses',
            'geom' => null, // Nanti diisi kordinat asli dari HP
        ]);

        Laporan::create([
            'id_user' => $user2->id,
            'nama_fasilitas' => 'Tanah Kuburan',
            'jenis_kerusakan' => 'Sedang',
            'deskripsi' => 'Lampu penerangan di tanah kuburan tersebut mengalami putus bohlam',
            'status' => 'Proses',
        ]);

        Laporan::create([
            'id_user' => $user1->id,
            'nama_fasilitas' => 'Parit',
            'jenis_kerusakan' => 'Menengah',
            'deskripsi' => 'Parit sudah mengalami kedangkalan yang amat mengkhawatirkan',
            'status' => 'Menunggu',
        ]);
    }
}
