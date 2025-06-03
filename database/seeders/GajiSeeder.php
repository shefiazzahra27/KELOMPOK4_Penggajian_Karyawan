<?php

namespace Database\Seeders;

use App\Models\Gaji;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GajiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gaji::insert([
            [
                'id_karyawan' => 1,
                'periode' => '05/2025',
                'gaji_pokok' => 5000000,
                'potongan' => 500000,
                'total_gaji' => 4500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_karyawan' => 2,
                'periode' => '05/2025',
                'gaji_pokok' => 4500000,
                'potongan' => 400000,
                'total_gaji' => 4100000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_karyawan' => 3,
                'periode' => '05/2025',
                'gaji_pokok' => 4000000,
                'potongan' => 300000,
                'total_gaji' => 3700000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_karyawan' => 4,
                'periode' => '05/2025',
                'gaji_pokok' => 3500000,
                'potongan' => 200000,
                'total_gaji' => 3300000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_karyawan' => 5,
                'periode' => '05/2025',
                'gaji_pokok' => 2500000,
                'potongan' => 100000,
                'total_gaji' => 2400000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
