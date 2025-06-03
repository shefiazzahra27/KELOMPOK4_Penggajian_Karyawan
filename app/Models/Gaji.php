<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $table = 'gajis';

    protected $fillable = [
        'id_karyawan',
        'periode',
        'gaji_pokok',
        'potongan',
        'total_gaji',
    ];

    // Relasi ke model Karyawan (foreign key: id_karyawan)
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
