<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;

    protected $table = 'penggajians'; // Sesuaikan dengan nama tabel di database

    protected $fillable = [
        'nama', // Sesuaikan dengan kolom di tabel
        'gaji',
        'tanggal'
    ];
}
