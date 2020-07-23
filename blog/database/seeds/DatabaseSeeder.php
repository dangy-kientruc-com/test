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
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
        	'name'=>'admin',
        	'email'=>'admin@gmail.com',
        	'email_verified_at'=>null,
        	'password'=>bcrypt('123456'),
        	'remember_token' => str_random(64),
        	'created_at' => null,
        	'updated_at' => null,
        ]);
    }
}
