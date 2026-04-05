<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhcalsQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Guna DB::table untuk kelajuan dan keselamatan
        DB::table('phcals_questions')->truncate();

        $questions = [];
        for ($i = 1; $i <= 50; $i++) {
            $questions[] = [
                'set_number' => 1,
                'question_text' => "Soalan Dummy PHCALS #$i: Apakah prosedur pertama dalam bantuan kecemasan ini?",
                'ans_a' => "Pilihan Jawapan A ($i)",
                'ans_b' => "Pilihan Jawapan B ($i)",
                'ans_c' => "Pilihan Jawapan C ($i)",
                'ans_d' => "Pilihan Jawapan D ($i)",
                'correct_answer' => 'B',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Masukkan semua sekali gus (Bulk Insert)
        DB::table('phcals_questions')->insert($questions);
    }
}