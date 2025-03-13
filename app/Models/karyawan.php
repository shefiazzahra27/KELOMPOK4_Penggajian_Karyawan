<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class karyawan extends Model
{
    public function up()
{
    Schema::create('penggajians', function (Blueprint $table) {
        $table->id();
        $table->string('nama_karyawan');
        $table->decimal('gaji_pokok', 10, 2);
        $table->decimal('tunjangan', 10, 2);
        $table->decimal('total_gaji', 10, 2);
        $table->timestamps();
    });
}
}
