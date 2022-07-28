<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChargesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('charges')->delete();
        DB::table('charges')->insert(['id' => 1]);
        DB::table('charges')->insert(['id' => 2]);

        DB::table('users')->delete();
        DB::table('users')->insert([
            'id' => 1,
            'role'=>1, 
            'first_name'=>'winsdev', 
            'email'=>'admin@gmail.com',
            'password'=>bcrypt('admin')
            ]);
      
    }
}
