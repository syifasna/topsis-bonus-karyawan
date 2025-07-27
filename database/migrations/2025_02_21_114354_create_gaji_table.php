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
        Schema::create('gaji', function (Blueprint $table) {
            $table->id();
            $table->string('bulan');
            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')->references('id')->on('karyawan');
            $table->integer('gajipokok');
            $table->unsignedBigInteger('jenis_id')->nullable();
            $table->foreign('jenis_id')->references('id')->on('jenisgaji');
            $table->unsignedBigInteger('absensi_id');
            $table->foreign('absensi_id')->references('id')->on('absensi');
            $table->integer('total');
            $table->string('terbilang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji');
    }
};
