<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
<<<<<<< HEAD
            KaryawanSeeder::class,
=======
            JabatanSeeder::class,
            KaryawanSeeder::class,
            KaryawanjabatanSeeder::class,
>>>>>>> 01dd47f23c57441eae1b33569c2fb511dff66cca
            GajiSeeder::class,
            AbsensiSeeder::class,
        ]);
    }
}
