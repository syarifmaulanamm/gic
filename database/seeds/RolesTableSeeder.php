<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'admin',
            'description' => 'All access'
        ]);

        DB::table('roles')->insert([
            'name' => 'bod',
            'description' => 'All access, both of director' 
        ]);

        DB::table('roles')->insert([
            'name' => 'gm',
            'description' => 'General manager approval'
        ]);

        DB::table('roles')->insert([
            'name' => 'hr',
            'description' => 'HR GA access'
        ]);

        DB::table('roles')->insert([
            'name' => 'staff',
            'description' => 'Request Only'
        ]);
    }
}
