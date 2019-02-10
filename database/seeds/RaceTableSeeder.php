<?php

use Illuminate\Database\Seeder;

class RaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        DB::table('races')->insert([
            'name' => 'Supersprint Distance',
            'details' => "Supersprint Distance 300M swim, 10KM bike, 2.5KM run",
            'published' => "yes",
            'event_id' => 1,
        ]);

        // 2
        DB::table('races')->insert([
            'name' => 'Olympic Distance',
            'details' => "Olympic Distance* 1500M swim, 40KM bike, 10KM run *Relay available in the Sprint and Olympic triathlons only",
            'published' => "yes",
            'event_id' => 1,
        ]);

        // 3
        DB::table('races')->insert([
            'name' => 'Sprint Distance',
            'details' => "Sprint Distance* 750M swim, 20KM bike, 5KM run *Relay available in the Sprint and Olympic triathlons only",
            'published' => "yes",
            'event_id' => 1,
        ]);

        // 4
        DB::table('races')->insert([
            'name' => 'Youth Race (ages 8-12)',
            'details' => "Youth Distance (ages 8-12) 100M swim, 4KM bike, 1KM run",
            'published' => "yes",
            'event_id' => 1,
        ]);

        // 5
        DB::table('races')->insert([
            'name' => '1K Kids Race (ages 5-8)',
            'details' => "1K Kids Race (ages 5-8)",
            'published' => "yes",
            'event_id' => 1,
        ]);

        // 6
        DB::table('races')->insert([
            'name' => 'Tribal Race',
            'details' => "Sprint distance followed by supersprint distance",
            'published' => "yes",
            'event_id' => 1,
        ]);
    }
}
