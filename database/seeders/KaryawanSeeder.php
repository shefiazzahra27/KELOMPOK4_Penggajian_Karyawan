<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Carbon;

use App\Models\Karyawan;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Karyawan::insert([
            [
                'nama' => 'John Doe',
                'nip' => '1234567890',
                'jenis_kelamin' => 'pria',
                'tanggal_lahir' => Carbon::create('1985', '05', '15'),
                'alamat' => 'Jl. Contoh No. 1, Jakarta',
                'jabatan' => 'manager',
                'tunjangan' => 5000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Jane Smith',
                'nip' => '1234567891',
                'jenis_kelamin' => 'perempuan',
                'tanggal_lahir' => Carbon::create('1990', '08', '22'),
                'alamat' => 'Jl. Contoh No. 2, Jakarta',
                'jabatan' => 'manager',
                'tunjangan' => 5000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Samuel Tan',
                'nip' => '1234567892',
                'jenis_kelamin' => 'pria',
                'tanggal_lahir' => Carbon::create('1992', '11', '30'),
                'alamat' => 'Jl. Contoh No. 3, Jakarta',
                'jabatan' => 'manager',
                'tunjangan' => 5000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Maria Gomez',
                'nip' => '1234567893',
                'jenis_kelamin' => 'perempuan',
                'tanggal_lahir' => Carbon::create('1988', '02', '11'),
                'alamat' => 'Jl. Contoh No. 4, Jakarta',
                'jabatan' => 'manager',
                'tunjangan' => 5000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Budi Santoso',
                'nip' => '1234567894',
                'jenis_kelamin' => 'pria',
                'tanggal_lahir' => Carbon::create('1995', '07', '04'),
                'alamat' => 'Jl. Contoh No. 5, Jakarta',
                'jabatan' => 'manager',
                'tunjangan' => 5000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
