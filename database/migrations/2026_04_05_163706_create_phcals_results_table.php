<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhcalsResultsTable extends Migration
{
    public function up()
    {
        Schema::create('phcals_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Link ke user yang menjawab
            $table->integer('set_number');
            $table->integer('score'); // Peratusan (0-100)
            $table->integer('correct_count'); // Bilangan betul (contoh: 50/50)
            $table->dateTime('start_time'); // Bila dia mula jawab
            $table->dateTime('end_time')->nullable(); // Bila dia hantar
            $table->timestamps();

            // Hubungkan dengan table users. Kalau user kena delete, sejarah ni pun hilang.
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('phcals_results');
    }
}