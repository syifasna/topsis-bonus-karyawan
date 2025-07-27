<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Karyawan extends Model
{
    protected $table = 'karyawan';
    protected $guarded = ['id'];

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
    }

    public function gaji(): HasMany
    {
        return $this->hasMany(Gaji::class, 'karyawan_id', 'id');
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'karyawan_id', 'id');
    }

    public function alternatif(): HasMany
    {
        return $this->hasMany(Alternatif::class, 'pendaftar_id', 'id');
    }

    public function perhitungan(): HasMany
    {
        return $this->hasMany(Perhitungan::class, 'pendaftar_id', 'id');
    }
}
