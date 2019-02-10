<?php

use Illuminate\Database\Seeder;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tickets')->insert([
            'name' => 'Tribal Race Ticket',
            'price' => "2400",
            'published' => "yes",
            'race_id' => 6,
            'quantity' => 30,
            'ticket_end' => '2019-03-27 00:00:00',
        ]);

        DB::table('tickets')->insert([
            'name' => 'SHEF - Youth Race Ticket (ages 8-12)',
            'price' => "600",
            'published' => "yes",
            'race_id' => 4,
            'quantity' => 200,
            'ticket_end' => '2019-03-20 00:00:00',
        ]);

        DB::table('tickets')->insert([
            'name' => 'SHEF - 1K Kids Race Ticket (ages 5-8)',
            'price' => "600",
            'published' => "yes",
            'race_id' => 5,
            'quantity' => 10000,
            'ticket_end' => '2019-03-31 00:00:00',
        ]);

        DB::table('tickets')->insert([
            'name' => 'SHEF - Supersprint Distance Individual Race Ticket - Male',
            'price' => "800",
            'published' => "yes",
            'race_id' => 3,
            'quantity' => 500,
            'ticket_end' => '2019-03-20 00:00:00',
        ]);

        DB::table('tickets')->insert([
            'name' => 'SHEF - Supersprint Distance Individual Race Ticket - Female',
            'price' => "800",
            'published' => "yes",
            'race_id' => 3,
            'quantity' => 500,
            'ticket_end' => '2019-03-20 00:00:00',
        ]);

        DB::table('tickets')->insert([
            'name' => 'SHEF - Olympic Individual Race Ticket',
            'price' => "800",
            'published' => "yes",
            'race_id' => 2,
            'quantity' => 500,
            'ticket_end' => '2019-03-20 00:00:00',
        ]);

        DB::table('tickets')->insert([
            'name' => 'SHEF - Olympic Relay Race Ticket',
            'price' => "800",
            'published' => "yes",
            'race_id' => 2,
            'quantity' => 500,
            'ticket_end' => '2019-03-20 00:00:00',
        ]);

        DB::table('tickets')->insert([
            'name' => 'SHEF - Sprint Individual Race Ticket',
            'price' => "800",
            'published' => "yes",
            'race_id' => 1,
            'quantity' => 500,
            'ticket_end' => '2019-03-20 00:00:00',
        ]);

        DB::table('tickets')->insert([
            'name' => 'SHEF - Sprint Relay Race Ticket',
            'price' => "1000",
            'published' => "yes",
            'race_id' => 1,
            'quantity' => 500,
            'ticket_end' => '2019-03-20 00:00:00',
        ]);
    }
}
