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
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'support@garditour.co.id',
            'password' => Hash::make('garditour63'),
            'role' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'name' => 'Merisdel Muslim',
            'email' => 'aris@garditour.co.id',
            'password' => Hash::make('garditour63'),
            'role' => 2,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'name' => 'General Manager',
            'email' => 'gm@garditour.co.id',
            'password' => Hash::make('garditour63'),
            'role' => 3,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'name' => 'HRGA',
            'email' => 'hrd@garditour.co.id',
            'password' => Hash::make('garditour63'),
            'role' => 4,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'name' => 'Operation',
            'email' => 'operation@garditour.co.id',
            'password' => Hash::make('garditour63'),
            'role' => 4,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
