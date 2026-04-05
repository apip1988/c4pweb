<?php

use Illuminate\Database\Seeder;
use App\PhcalsQuestion; // Pastikan huruf besar kecil betul

class PhcalsQuestionSeeder extends Seeder
{
    public function run()
    {
        // Guna DB truncate kalau model tak jumpa
        \DB::table('phcals_questions')->truncate();

        for ($i = 1; $i <= 50; $i++) {
            \DB::table('phcals_questions')->insert([
                'set_number' => 1,
                'question_text' => "Ini adalah Soalan Dummy PHCALS No. $i. Apakah tindakan anda?",
                'ans_a' => "Pilihan Jawapan A bagi soalan $i",
                'ans_b' => "Pilihan Jawapan B bagi soalan $i",
                'ans_c' => "Pilihan Jawapan C bagi soalan $i",
                'ans_d' => "Pilihan Jawapan D bagi soalan $i",
                'correct_answer' => 'B',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}