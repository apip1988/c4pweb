<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('kompetensi_permohonans', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // Hubungan ke table users
        $table->string('status_pengesahan')->default('PENDING'); 
        $table->string('status_layak')->nullable(); 
        $table->date('tarikh_exam')->nullable();
        $table->time('masa_exam')->nullable();
        $table->string('medium')->nullable(); 
        $table->string('lokasi_pautan')->nullable();
        $table->string('keputusan')->nullable(); // LULUS, GAGAL, TIDAK HADIR & GAGAL
        $table->timestamps();

        // Buat relationship dengan table users
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kompetensi_permohonans');
    }
};
