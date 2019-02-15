<?php

use Illuminate\Database\Seeder;

class AnswerValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        DB::table('answervalues')->insert([
            'value' => 'Small',
            'question_id' => 1,
        ]);

        // 2
        DB::table('answervalues')->insert([
            'value' => 'Medium',
            'question_id' => 1,
        ]);

        // 3
        DB::table('answervalues')->insert([
            'value' => 'Large',
            'question_id' => 1,
        ]);

        // 4
        DB::table('answervalues')->insert([
            'value' => 'X-Large',
            'question_id' => 1,
        ]);

        // 5
        DB::table('answervalues')->insert([
            'value' => 'Male',
            'question_id' => 28,
        ]);

        // 6
        DB::table('answervalues')->insert([
            'value' => 'Female',
            'question_id' => 28,
        ]);

        // 7
        DB::table('answervalues')->insert([
            'value' => '6 - 8',
            'question_id' => 30,
        ]);

        // 8
        DB::table('answervalues')->insert([
            'value' => '8 - 10',
            'question_id' => 30,
        ]);

        // 9
        DB::table('answervalues')->insert([
            'value' => '10 - 12',
            'question_id' => 30,
        ]);

        // 10
        DB::table('answervalues')->insert([
            'value' => '12 - 14',
            'question_id' => 30,
        ]);

        // 11
        DB::table('answervalues')->insert([
            'value' => 'Male',
            'question_id' => 18,
        ]);

        // 12
        DB::table('answervalues')->insert([
            'value' => 'Female',
            'question_id' => 18,
        ]);

        // 13
        DB::table('answervalues')->insert([
            'value' => 'Small',
            'question_id' => 19,
        ]);

        // 14
        DB::table('answervalues')->insert([
            'value' => 'Medium',
            'question_id' => 19,
        ]);

        // 15
        DB::table('answervalues')->insert([
            'value' => 'Large',
            'question_id' => 19,
        ]);

        // 16
        DB::table('answervalues')->insert([
            'value' => 'X-Large',
            'question_id' => 19,
        ]);

        // 17
        DB::table('answervalues')->insert([
            'value' => 'Male',
            'question_id' => 22,
        ]);

        // 18
        DB::table('answervalues')->insert([
            'value' => 'Female',
            'question_id' => 22,
        ]);

        // 19
        DB::table('answervalues')->insert([
            'value' => 'Small',
            'question_id' => 23,
        ]);

        // 20
        DB::table('answervalues')->insert([
            'value' => 'Medium',
            'question_id' => 23,
        ]);

        // 21
        DB::table('answervalues')->insert([
            'value' => 'Large',
            'question_id' => 23,
        ]);

        // 22
        DB::table('answervalues')->insert([
            'value' => 'X-Large',
            'question_id' => 23,
        ]);

        // 23
        DB::table('answervalues')->insert([
            'value' => 'Male',
            'question_id' => 13,
        ]);

        // 24
        DB::table('answervalues')->insert([
            'value' => 'Female',
            'question_id' => 13,
        ]);

        // 25
        DB::table('answervalues')->insert([
            'value' => 'Small',
            'question_id' => 14,
        ]);

        // 26
        DB::table('answervalues')->insert([
            'value' => 'Medium',
            'question_id' => 14,
        ]);

        // 27
        DB::table('answervalues')->insert([
            'value' => 'Large',
            'question_id' => 14,
        ]);

        // 28
        DB::table('answervalues')->insert([
            'value' => 'X-Large',
            'question_id' => 14,
        ]);

        // 29
        DB::table('answervalues')->insert([
            'value' => 'Less than 1:30 minutes per 100 meters (Fast swimmer)',
            'question_id' => 15,
        ]);
        
        // 30
        DB::table('answervalues')->insert([
            'value' => 'Between 1:30 - 2:00 minutes per 100 meters (Good swimmer)',
            'question_id' => 15,
        ]);

        // 31
        DB::table('answervalues')->insert([
            'value' => 'Between 2:00 - 2:30 minutes per 100 meters (OK swimmer)',
            'question_id' => 15,
        ]);

        // 32
        DB::table('answervalues')->insert([
            'value' => 'More than 2:30 minutes per 100 meters (Slow swimmer)',
            'question_id' => 15,
        ]);

        // 33
        DB::table('answervalues')->insert([
            'value' => 'Less than 1:30 minutes per 100 meters (Fast swimmer)',
            'question_id' => 3,
        ]);
        
        // 334
        DB::table('answervalues')->insert([
            'value' => 'Between 1:30 - 2:00 minutes per 100 meters (Good swimmer)',
            'question_id' => 3,
        ]);

        // 35
        DB::table('answervalues')->insert([
            'value' => 'Between 2:00 - 2:30 minutes per 100 meters (OK swimmer)',
            'question_id' => 3,
        ]);

        // 36
        DB::table('answervalues')->insert([
            'value' => 'More than 2:30 minutes per 100 meters (Slow swimmer)',
            'question_id' => 3,
        ]);

        // 37
        DB::table('answervalues')->insert([
            'value' => 'The TriFactory Team',
            'question_id' => 2,
        ]);

        // 38
        DB::table('answervalues')->insert([
            'value' => 'Gezira Triathlon Team',
            'question_id' => 2,
        ]);

        // 39
        DB::table('answervalues')->insert([
            'value' => 'Maadi Athletes',
            'question_id' => 2,
        ]);

        // 40
        DB::table('answervalues')->insert([
            'value' => 'GBI',
            'question_id' => 2,
        ]);

        // 41
        DB::table('answervalues')->insert([
            'value' => 'Velocity Triathlon',
            'question_id' => 2,
        ]);

        // 42
        DB::table('answervalues')->insert([
            'value' => 'The Tritaniums',
            'question_id' => 2,
        ]);

        // 43
        DB::table('answervalues')->insert([
            'value' => 'Power Ride Sports',
            'question_id' => 2,
        ]);

        // 44
        DB::table('answervalues')->insert([
            'value' => 'Stamina Tri Teams',
            'question_id' => 2,
        ]);

        // 45
        DB::table('answervalues')->insert([
            'value' => 'Cairo Runners',
            'question_id' => 2,
        ]);

        // 46
        DB::table('answervalues')->insert([
            'value' => 'Alex Runners',
            'question_id' => 2,
        ]);
        
        // 47
        DB::table('answervalues')->insert([
            'value' => 'Maadi Runners',
            'question_id' => 2,
        ]);
        
        // 48
        DB::table('answervalues')->insert([
            'value' => 'Alamedi Tri Team',
            'question_id' => 2,
        ]);

        // 49
        DB::table('answervalues')->insert([
            'value' => 'Boost',
            'question_id' => 2,
        ]);

        // 50
        DB::table('answervalues')->insert([
            'value' => 'Fit4Life',
            'question_id' => 2,
        ]);

        // 51
        DB::table('answervalues')->insert([
            'value' => 'Swimzone',
            'question_id' => 2,
        ]);

        // 52
        DB::table('answervalues')->insert([
            'value' => 'Sharm Tri Team',
            'question_id' => 2,
        ]);

        // 53
        DB::table('answervalues')->insert([
            'value' => 'One Shot Cycling Team',
            'question_id' => 2,
        ]);

        // 54
        DB::table('answervalues')->insert([
            'value' => 'Cairo Crit',
            'question_id' => 2,
        ]);

        // 55
        DB::table('answervalues')->insert([
            'value' => 'Zamalek Runners',
            'question_id' => 2,
        ]);

        // 56
        DB::table('answervalues')->insert([
            'value' => 'Night Runners',
            'question_id' => 2,
        ]);

        // 57
        DB::table('answervalues')->insert([
            'value' => 'The Family Team',
            'question_id' => 2,
        ]);

        // 58
        DB::table('answervalues')->insert([
            'value' => 'Wheelers',
            'question_id' => 2,
        ]);

        // 59
        DB::table('answervalues')->insert([
            'value' => 'October Cyclers',
            'question_id' => 2,
        ]);

        // 60
        DB::table('answervalues')->insert([
            'value' => 'Monsters',
            'question_id' => 2,
        ]);

        // 61
        DB::table('answervalues')->insert([
            'value' => 'Tri-Wezzas',
            'question_id' => 2,
        ]);

        // 61
        DB::table('answervalues')->insert([
            'value' => 'Cycling Elite',
            'question_id' => 2,
        ]);

        // 62
        DB::table('answervalues')->insert([
            'value' => 'Other',
            'question_id' => 2,
        ]);

        // 63
        DB::table('answervalues')->insert([
            'value' => 'I am an Independent Athlete',
            'question_id' => 2,
        ]);

        // 64
        DB::table('answervalues')->insert([
            'value' => 'Male',
            'question_id' => 31,
        ]);

        // 65
        DB::table('answervalues')->insert([
            'value' => 'Female',
            'question_id' => 31,
        ]);
    }
}
