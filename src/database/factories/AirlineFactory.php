<?php

namespace Database\Factories;

use App\Models\Airline;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Airline>
 */
class AirlineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $airlineList = Airline::getAirlineList();
        $key = array_keys($airlineList);
        $airlineKeyArr = $this->faker->unique()->randomElements($key); //To make sure we don't enter the same airline two time  s in the DB
        $airline = $airlineList[$airlineKeyArr[0]];

        //Since we only have 3 airports, to fill the DB with our data, run the following line
        //Airline::factory()->count(3)->create();

        return [
            'code' => $airline->code,
            'name' => $airline->name,
        ];
    }
}
