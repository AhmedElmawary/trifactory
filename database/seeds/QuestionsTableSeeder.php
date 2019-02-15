<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        DB::table('questions')->insert([
            'question_text' => 'T-Shirt Size',
            'answertype_id' => 1,
        ]);

        // 2
        DB::table('questions')->insert([
            'question_text' => 'What club do you represent (if any)?',
            'answertype_id' => 1,
        ]);

        // 3
        DB::table('questions')->insert([
            'question_text' => 'What is your average swim pace? (Please give us your best estimate to help us arrange participants according to pace at the start line for safety)',
            'answertype_id' => 1,
        ]);

        // 4
        DB::table('questions')->insert([
            'question_text' => 'Nationality',
            'answertype_id' => 6,
        ]);

        // 5
        DB::table('questions')->insert([
            'question_text' => 'Year of Birth',
            'answertype_id' => 5,
        ]);

        // 6
        DB::table('questions')->insert([
            'question_text' => 'Country of Residence',
            'answertype_id' => 6,
        ]);

        // 7
        DB::table('questions')->insert([
            'question_text' => 'Emergency Contact Name',
            'answertype_id' => 2,
        ]);

        // 8
        DB::table('questions')->insert([
            'question_text' => 'Emergnecy Contact Number',
            'answertype_id' => 4,
        ]);

        // 9
        DB::table('questions')->insert([
            'question_text' => 'Others - please specify',
            'answertype_id' => 2,
        ]);

        // 10
        DB::table('questions')->insert([
            'question_text' => 'Team Name',
            'answertype_id' => 2,
        ]);
        
        // 11
        DB::table('questions')->insert([
            'question_text' => 'Swimmer - Full name',
            'answertype_id' => 2,
        ]);

        // 12
        DB::table('questions')->insert([
            'question_text' => 'Swimmer - Email',
            'answertype_id' => 3,
        ]);

        // 13
        DB::table('questions')->insert([
            'question_text' => 'Swimmer - Gender',
            'answertype_id' => 1,
        ]);
        
        // 14
        DB::table('questions')->insert([
            'question_text' => 'Swimmer - T-shirt Size',
            'answertype_id' => 1,
        ]);

        // 15
        DB::table('questions')->insert([
            'question_text' => 'Swimmer - What is your average swim pace? (Please give us your best estimate to help us arrange participants according to pace at the start line for safety)',
            'answertype_id' => 1,
        ]);

        // 16
        DB::table('questions')->insert([
            'question_text' => 'Cyclist - Full name',
            'answertype_id' => 2,
        ]);

        // 17
        DB::table('questions')->insert([
            'question_text' => 'Cyclist - Email',
            'answertype_id' => 3,
        ]);
        
        // 18
        DB::table('questions')->insert([
            'question_text' => 'Cyclist - Gender',
            'answertype_id' => 1,
        ]);

        // 19
        DB::table('questions')->insert([
            'question_text' => 'Cyclist - T-shirt Size',
            'answertype_id' => 1,
        ]);
        
        // 20
        DB::table('questions')->insert([
            'question_text' => 'Runner - Full name',
            'answertype_id' => 2,
        ]);
        
        // 21
        DB::table('questions')->insert([
            'question_text' => 'Runner - Email',
            'answertype_id' => 3,
        ]);

        // 22
        DB::table('questions')->insert([
            'question_text' => 'Runner - Gender',
            'answertype_id' => 1,
        ]);
        
        // 23
        DB::table('questions')->insert([
            'question_text' => 'Runner - T-shirt Size',
            'answertype_id' => 1,
        ]);
        
        // 24
        DB::table('questions')->insert([
            'question_text' => 'Parent/Guardian Name',
            'answertype_id' => 2,
        ]);

        // 25
        DB::table('questions')->insert([
            'question_text' => 'Parent/Guardian Email',
            'answertype_id' => 3,
        ]);

        // 26
        DB::table('questions')->insert([
            'question_text' => 'Parent/Guardian Mobile Number',
            'answertype_id' => 4,
        ]);
        
        // 27
        DB::table('questions')->insert([
            'question_text' => 'Child\'s Name',
            'answertype_id' => 2,
        ]);

        // 28
        DB::table('questions')->insert([
            'question_text' => 'Child\'s Gender',
            'answertype_id' => 1,
        ]);
        
        // 29
        DB::table('questions')->insert([
            'question_text' => 'Child\'s Year of Birth',
            'answertype_id' => 5,
        ]);

        // 30
        DB::table('questions')->insert([
            'question_text' => 'Child\'s T-shirt Size',
            'answertype_id' => 1,
        ]);
        
        // 31
        DB::table('questions')->insert([
            'question_text' => 'Gender',
            'answertype_id' => 1,
        ]);
    }
}
