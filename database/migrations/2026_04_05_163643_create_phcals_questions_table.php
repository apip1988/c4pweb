<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhcalsQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('phcals_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('set_number'); // Set 1, 2, 3, 4, atau 5
            $table->text('question_text'); // Teks soalan
            $table->string('ans_a');
            $table->string('ans_b');
            $table->string('ans_c');
            $table->string('ans_d');
            $table->string('correct_answer'); // A, B, C, atau D
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phcals_questions');
    }
}