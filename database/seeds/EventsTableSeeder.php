<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Event::truncate();

      $faker = \Faker\Factory::create();

      for ($i = 0; $i < 30; $i++) {
          Event::create([
              'title' => $faker->unique()->sentence(),
              'description' => $faker->option()->paragraphs(2, true),
              'location' => $faker->address(),
              'category' => $faker->randomElement(['sport', 'culture', 'other']),
              'date_time' => $faker->unixTime()
              'organiser_id' => $faker->numberBetween(0, 10);
          ]);
    }
}
