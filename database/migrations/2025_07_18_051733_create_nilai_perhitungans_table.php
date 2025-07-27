<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilai_perhitungans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('perhitungan_id');
            $table->foreign('perhitungan_id')->references('id')->on('perhitungans');
            $table->unsignedBigInteger('kriteria_id');
            $table->foreign('kriteria_id')->references('id')->on('kriterias');
            $table->decimal('nilai', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_perhitungans');
    }
};
