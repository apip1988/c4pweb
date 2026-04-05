<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Bina Table Users (Pendaftaran Utama)
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Kolum Tambahan yang Afif perlukan
            $table->string('ic_number', 12)->unique()->nullable();
            $table->string('phone_number')->nullable();
            $table->string('no_lpp')->nullable();
            $table->string('sektor')->nullable();
            $table->string('ptj_sekarang')->nullable();
            $table->date('tarikh_lantikan')->nullable();
            
            // Kolum Pendidikan (Untuk PHCALS & Kompetensi)
            $table->string('edu_diploma')->default('TIADA');
            $table->string('edu_ijazah')->default('TIADA');
            $table->string('edu_master')->default('TIADA');
            $table->string('edu_post_basic')->default('TIADA');
            $table->string('edu_phd')->default('TIADA');

            $table->string('role')->default('USER'); // ADMIN atau USER
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Padam Table jika Rollback
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}