<?php

use Illuminate\Database\Seeder;
use App\Event;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = \Faker\Factory::create();

      for ($i = 0; $i < 30; $i++) {
          Event::create([
              'title' => $faker->unique()->sentence(),
              'description' => $faker->optional()->paragraphs(1, true),
              'location' => $faker->address(),
              'category' => $faker->randomElement(['sport', 'culture', 'other']),
              'date_time' => $faker->dateTime(),
              'organiser_id' => $faker->numberBetween(1, 10)
          ]);
      }
    }
}
