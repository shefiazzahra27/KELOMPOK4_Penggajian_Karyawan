<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatans';

    protected $guarded = ['id'];

    public function karyawans()
    {
        return $this->belongsToMany(Karyawan::class, 'karyawan_jabatans', 'id_jabatan', 'id_karyawan')
            ->using(KaryawanJabatan::class)
            ->withTimestamps();
    }
}
