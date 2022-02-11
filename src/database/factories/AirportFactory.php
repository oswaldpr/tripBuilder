<?php

namespace Database\Factories;

use App\Models\Airport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Airport>
 */
class AirportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $airportList = Airport::getAirportList();

        $key = array_keys($airportList);
        $airlineKeyArr = $this->faker->unique()->randomElements($key); //To make sure we don't enter the same airport two time  s in the DB
        $airport = $airportList[$airlineKeyArr[0]];

        //Since we only have 5 airports, to fill the DB with our data, run the following line
        //Airport::factory()->count(5)->create();
        return [
            'code' => $airport->code,
            'city_code' => $airport->city_code,
            'name' => $airport->name,
            'city' => $airport->city,
            'country_code' => $airport->country_code,
            'region_code' => $airport->region_code,
            'latitude' => $airport->latitude,
            'longitude' => $airport->longitude,
            'timezone' => $airport->timezone,
        ];
    }
}
