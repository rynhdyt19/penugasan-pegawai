<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'nip' => '199001012015011002',
            'name' => 'Admin Sistem',
            'email' => 'adminn@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'jabatan' => 'Administrator',
            'seksi' => 'IT',
            'kontak' => '081234567890',
        ]);

        // Pegawai
        User::create([
            'nip' => '199001012015011001',
            'name' => 'Pegawai 1',
            'email' => 'pegawai1@example.com',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
            'jabatan' => 'Staff',
            'seksi' => 'Umum',
            'kontak' => '081234567801',
            'max_tugas_mingguan' => 5,
            'max_tugas_bulanan' => 20,
        ]);
    }
}
