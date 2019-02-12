<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        DB::table('users')->insert([
            'name' => 'admin admin',
            'firstname' => 'admin',
            'lastname' => 'admin',
            'email' => "admin@admin.com",
            'password' =>  bcrypt('admin'),
        ]);

        DB::table('users')->insert([
            'name' => 'Sherief El-Feky',
            'firstname' => 'Sherief',
            'lastname' => 'El-Feky',
            'email' => "sherief.elfeky@gmail.com",
            'phone' => "01222274911",
            'password' =>  bcrypt('br3adcrumbs'),
        ]);
    }
}
