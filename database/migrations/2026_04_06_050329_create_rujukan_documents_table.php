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
    Schema::create('rujukan_documents', function (Blueprint $table) {
        $table->id();
        $table->string('type');          // SPG, Surat, Guideline, Minit Mesyuarat
        $table->string('title');         // Tajuk Dokumen
        $table->string('publisher');     // Dari Siapa (MKM, KKM, dsb)
        $table->year('year');            // Tahun
        $table->string('file_path');     // Path fail PDF
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rujukan_documents');
    }
};
