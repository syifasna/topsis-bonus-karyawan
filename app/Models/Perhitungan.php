<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perhitungan extends Model
{
    protected $guarded = ['id'];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id');
    }

    public function alternatif(): BelongsTo
    {
        return $this->belongsTo(Alternatif::class, 'alternatif_id', 'id');
    }

    public function nilaiPerhitungan(): HasMany
    {
        return $this->hasMany(NilaiPerhitungan::class, 'perhitungan_id', 'id');
    }
}
