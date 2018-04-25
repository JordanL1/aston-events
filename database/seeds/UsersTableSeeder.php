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
      User::truncate();

      $password = Hash::make('abcdefgh');

      $faker = \Faker\Factory::create();

      for ($i = 0; $i < 10; $i++) {
          User::create([
              'name' => $faker->name,
              'email' => $faker->email,
              'password' => $password,
          ]);
      }
    }
}
