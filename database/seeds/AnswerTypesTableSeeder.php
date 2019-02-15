<?php

use Illuminate\Database\Seeder;

class AnswerTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        DB::table('answertype')->insert([
            'name' => 'Dropdown List',
            'type' => "dropdown",
        ]);

        // 2
        DB::table('answertype')->insert([
            'name' => 'Text Input',
            'type' => "input",
        ]);

        // 3
        DB::table('answertype')->insert([
            'name' => 'Email',
            'type' => "input",
            'validation' => 'email'
        ]);

        // 4
        DB::table('answertype')->insert([
            'name' => 'Phone number',
            'type' => "input",
            'validation' => 'phone'
        ]);

        // 5
        DB::table('answertype')->insert([
            'name' => 'Year of birth',
            'type' => "input",
            'validation' => 'date'
        ]);

        // 6
        DB::table('answertype')->insert([
            'name' => 'Countries dropdown',
            'type' => "countries",
        ]);
    }
}
