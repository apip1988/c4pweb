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
        $table->unsignedBigInteger('user_id'); // ID User yang jawab
        $table->integer('set_id');             // Set 1, 2 atau 3
        $table->decimal('score', 5, 2);        // Markah (contoh: 100.00)
        $table->string('status');              // PASSED atau RE-ATTEMPT
        $table->longText('review_data');       // Simpan semua jawapan user (JSON) untuk fungsi Review
        $table->timestamp('attempt_date');     // Tarikh ambil ujian
        $table->timestamp('expiry_date');      // Tarikh luput (3 tahun)
        $table->timestamps();

        // Hubungkan dengan table users
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    public function down()
    {
        Schema::dropIfExists('phcals_results');
    }
}