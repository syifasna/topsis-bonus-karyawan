<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiPerhitungan extends Model
{
    protected $guarded = ['id'];

    public function perhitungan(): BelongsTo
    {
        return $this->belongsTo(Perhitungan::class, 'perhitungan_id', 'id');
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id', 'id');
    }
}
