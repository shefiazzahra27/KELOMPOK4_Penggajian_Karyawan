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
        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_karyawan')->references('id')->on('karyawans')->onDelete('cascade');
            $table->string('periode'); // Format: Bulan/Tahun (misal: 05/2025)
            $table->integer('gaji_pokok')->default(0);
            $table->integer('potongan')->default(0);
            $table->integer('total_gaji')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};
