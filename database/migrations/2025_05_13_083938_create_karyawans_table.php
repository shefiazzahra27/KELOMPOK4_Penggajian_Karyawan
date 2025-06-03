<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->unique();
            $table->enum('jenis_kelamin', ['pria', 'perempuan']);
            $table->date('tanggal_lahir');
            $table->text('alamat')->nullable();
            $table->enum('jabatan', ['manager', 'kepala divisi', 'karyawan tetap', 'karyawan kontrak', 'office boy']);
            $table->integer('tunjangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
