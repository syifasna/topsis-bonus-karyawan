<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Gaji extends Model
{
    protected $table = 'gaji';
    protected $guarded = ['id'];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id');
    }

    public function jenisGaji(): BelongsToMany
    {
        return $this->belongsToMany(JenisGaji::class, 'gaji_jenisgaji', 'gaji_id', 'jenis_id')
                    ->withPivot('nominal')
                    ->withTimestamps();
    }

    public function absensi(): BelongsTo
    {
        return $this->belongsTo(Absensi::class, 'absensi_id', 'id');
    }

    public function getTotalHasilAttribute()
    {
        return $this->jenisGaji->where('tipe', 'Penghasilan')->sum('pivot.nominal');
    }

    public function getTotalPotAttribute()
    {
        return $this->jenisGaji->where('tipe', 'Potongan')->sum('pivot.nominal');
    }
}
