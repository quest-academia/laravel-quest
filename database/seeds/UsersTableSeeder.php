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
        DB::Table('users')->insert([
            'name'=>'sample1',
            'email'=>'sample@sample.com',
            'password'=>bcrypt('sample1')
            ]);
         DB::Table('users')->insert([
            'name'=>'sample2',
            'email'=>'sample2@sample.com',
            'password'=>bcrypt('sample2')
            ]);
         DB::Table('users')->insert([
            'name'=>'sample3',
            'email'=>'sample3@sample.com',
            'password'=>bcrypt('sample2')
            ]);
         DB::Table('users')->insert([
            'name'=>'sample4',
            'email'=>'sample4@sample.com',
            'password'=>bcrypt('sample4')
            ]);
         DB::Table('users')->insert([
            'name'=>'sample5',
            'email'=>'sample5@sample.com',
            'password'=>bcrypt('sample5')
            ]);
    }
}
