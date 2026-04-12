<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonansTableV2 extends Migration
{
    public function up()
    {
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('ic_number');
            $table->string('email');
            $table->string('sektor')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('ptj_sekarang')->nullable();
            $table->string('status')->default('PENDING');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permohonans');
    }
}