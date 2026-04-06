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
    Schema::create('credentialing_documents', function (Blueprint $table) {
        $table->id();
        $table->string('discipline');      // Disiplin (Cardio, etc)
        $table->string('document_type');   // Jenis (Buku Log, etc)
        $table->string('title');           // Nama fail untuk display
        $table->string('file_path');       // Path fail PDF
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credentialing_documents');
    }
};
