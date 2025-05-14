<?php

namespace Database\Seeders;


use App\Models\KaryawanJabatan;
use Illuminate\Database\Seeder;

class KaryawanJabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KaryawanJabatan::insert([
            ['id_karyawan' => 1, 'id_jabatan' => 1], // John Doe -> Manager
            ['id_karyawan' => 2, 'id_jabatan' => 2], // Jane Smith -> Kepala Divisi
            ['id_karyawan' => 3, 'id_jabatan' => 3], // Samuel Tan -> Karyawan Tetap
            ['id_karyawan' => 4, 'id_jabatan' => 4], // Maria Gomez -> Karyawan Kontrak
            ['id_karyawan' => 5, 'id_jabatan' => 5], // Budi Santoso -> Office Boy
        ]);
    }
}
