<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRujukanDocumentsTable extends Migration
{
    public function up()
    {
        // Guna hasTable supaya kalau table dah ada, dia tak error
        if (!Schema::hasTable('rujukans')) {
            Schema::create('rujukans', function (Blueprint $table) {
                $table->id();
                $table->string('type');      // SPG, Surat, dsb
                $table->string('title');     // Tajuk
                $table->string('publisher'); // Pengeluar
                $table->string('year');      // Tahun
                $table->string('file_path'); // Path PDF
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('rujukans');
    }
}