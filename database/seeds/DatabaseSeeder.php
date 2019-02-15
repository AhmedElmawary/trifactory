<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(AnswerTypesTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
        $this->call(AnswerValuesTableSeeder::class);
        $this->call(RaceQuestionsTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(RaceTableSeeder::class);
        $this->call(TicketsTableSeeder::class);
    }
}
