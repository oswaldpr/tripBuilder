<?php

namespace Database\Factories;

use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $flightList = Flight::getFlightList();
        $key = array_keys($flightList);
        $flightKeyArr = $this->faker->unique()->randomElements($key); //To make sure we don't enter the same flight two time  s in the DB
        $airline = $flightList[$flightKeyArr[0]];

        //Since we only have 12 flights, to fill the DB with our data, run the following line
        //Flight::factory()->count(12)->create();

        return [
            'airline' => $airline->airline,
            'number' => $airline->number,
            'departure_airport' => $airline->departure_airport,
            'departure_time' => $airline->departure_time,
            'arrival_airport' => $airline->arrival_airport,
            'arrival_time' => $airline->arrival_time,
            'price' => $airline->price,
            'airline_id' => $airline->airline_id,
            'departure_airport_id' => $airline->departure_airport_id,
            'arrival_airport_id' => $airline->arrival_airport_id,
        ];
    }
}
