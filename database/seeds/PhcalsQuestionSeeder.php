<?php

use Illuminate\Database\Seeder;
use App\PhcalsQuestion; // Pastikan model ini wujud

class PhcalsQuestionSeeder extends Seeder
{
    public function run()
    {
        // Kosongkan table dulu sebelum isi baru (elak soalan bertindih)
        PhcalsQuestion::truncate();

        for ($i = 1; $i <= 50; $i++) {
            PhcalsQuestion::create([
                'set_number' => 1, // Kita buat Set 1 dulu
                'question_text' => "Ini adalah Soalan Dummy PHCALS No. $i. Apakah tindakan anda?",
                'ans_a' => "Pilihan Jawapan A bagi soalan $i",
                'ans_b' => "Pilihan Jawapan B bagi soalan $i",
                'ans_c' => "Pilihan Jawapan C bagi soalan $i",
                'ans_d' => "Pilihan Jawapan D bagi soalan $i",
                'correct_answer' => 'B', // Kita set semua jawapan betul adalah B buat sementara
            ]);
        }
    }
}