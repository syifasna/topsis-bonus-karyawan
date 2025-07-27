<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JenisGaji extends Model
{
    protected $table = 'jenisgaji';
    protected $guarded = ['id'];

    public function gaji(): BelongsToMany
    {
        return $this->belongsToMany(Gaji::class, 'gaji_jenisgaji', 'jenis_id', 'gaji_id')
                    ->withPivot('nominal')
                    ->withTimestamps();
    }
}
