<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Carbon;
use App\Models\Absensi;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Absensi::insert([
            [
                'id_karyawan' => 1,
                'tanggal' => Carbon::create('2025', '05', '01'),
                'status' => 'Hadir',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_karyawan' => 2,
                'tanggal' => Carbon::create('2025', '05', '01'),
                'status' => 'Izin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_karyawan' => 3,
                'tanggal' => Carbon::create('2025', '05', '01'),
                'status' => 'Sakit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_karyawan' => 4,
                'tanggal' => Carbon::create('2025', '05', '01'),
                'status' => 'Alpha',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_karyawan' => 5,
                'tanggal' => Carbon::create('2025', '05', '01'),
                'status' => 'Hadir',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
