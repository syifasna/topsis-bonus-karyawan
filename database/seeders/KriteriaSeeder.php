<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kriteria::insert([
            [
                'nkriteria' => 'Kehadiran',
                'atribut' => 'Benefit',
                'bobot' => 0.4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nkriteria' => 'Kualitas Karakter',
                'atribut' => 'Benefit',
                'bobot' => 0.3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nkriteria' => 'Tanggung Jawab',
                'atribut' => 'Benefit',
                'bobot' => 0.3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
