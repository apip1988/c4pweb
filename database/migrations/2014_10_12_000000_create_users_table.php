<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('ic_number', 12)->unique()->after('email');
        $table->string('phone_number')->nullable()->after('ic_number');
        $table->string('no_lpp')->nullable()->after('phone_number');
        $table->string('sektor')->nullable()->after('no_lpp');
        $table->string('ptj_sekarang')->nullable()->after('sektor');
        $table->date('tarikh_lantikan')->nullable()->after('ptj_sekarang');
        $table->string('role')->default('USER')->after('tarikh_lantikan');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['ic_number', 'phone_number', 'no_lpp', 'sektor', 'ptj_sekarang', 'tarikh_lantikan', 'role']);
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
