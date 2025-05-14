<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawans';

    protected $guarded = ['id'];

    /**
     * Relasi ke tabel absensi (1 karyawan punya banyak absensi)
     */
    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'id_karyawan'); // menambahkan 'id_karyawan'
    }

    /**
     * Relasi ke tabel gaji (1 karyawan punya banyak catatan gaji)
     */
    public function gajis()
    {
        return $this->hasMany(Gaji::class, 'id_karyawan'); // menambahkan 'id_karyawan'
    }


    /**
     * Relasi ke tabel jabatan melalui pivot (many-to-many)
     */
    public function jabatans()
    {
        return $this->belongsToMany(Jabatan::class, 'karyawan_jabatans', 'id_karyawan', 'id_jabatan')
            ->using(KaryawanJabatan::class)
            ->withTimestamps();
    }
}