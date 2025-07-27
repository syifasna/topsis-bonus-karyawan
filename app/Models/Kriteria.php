<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kriteria extends Model
{
    protected $guarded = ['id'];

    public function NilaiPerhitungan(): HasMany
    {
        return $this->hasMany(NilaiPerhitungan::class, 'kriteria_id', 'id');
    }
}
