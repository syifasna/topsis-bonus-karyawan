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
        Schema::create('gaji_jenisgaji', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gaji_id')->constrained('gaji')->onDelete('cascade');
            $table->foreignId('jenis_id')->constrained('jenisgaji')->onDelete('cascade');
            $table->integer('nominal')->default(0); 
            $table->timestamps();

            $table->unique(['gaji_id', 'jenis_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_jenisgaji');
    }
};
