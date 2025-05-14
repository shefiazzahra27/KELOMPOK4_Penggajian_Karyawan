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
        Schema::create('karyawan_jabatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_karyawan')->references('id')->on('karyawans')->onDelete('cascade');
            $table->foreignId('id_jabatan')->references('id')->on('jabatans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan_jabatans');
    }
};
