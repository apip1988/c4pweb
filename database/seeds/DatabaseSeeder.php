<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kita guna nama class dalam bentuk 'string' untuk lebih selamat
        $this->call('PhcalsQuestionSeeder');
    }
}