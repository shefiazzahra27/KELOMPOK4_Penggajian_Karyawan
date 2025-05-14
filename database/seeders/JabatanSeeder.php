<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jabatan::insert([
            [
                'nama_jabatan' => 'manager',
                'tunjangan' => 5000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jabatan' => 'Kepala Divisi',
                'tunjangan' => 4000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jabatan' => 'Karyawan Tetap',
                'tunjangan' => 2500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jabatan' => 'Karyawan Kontrak',
                'tunjangan' => 2000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jabatan' => 'Office Boy',
                'tunjangan' => 1500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
