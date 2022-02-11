<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function getFlightList()
    {
        //AT:YUL-JFK (2h)
        $YUL_JFK = Flight::createFlight("AT","302","YUL","07:35","JFK","10:05",200.23);
        $JFK_YUL = Flight::createFlight("AT","302","JFK","11:30","YUL","19:11",220.63);

        //AC:YUL-YVR (3h)
        $YUL_YVR = Flight::createFlight("AC","303","YUL","07:35","YVR","10:05",300.23);
        $YVR_YUL = Flight::createFlight("AC","303","YVR","11:30","YUL","19:11",330.63);

        //AC:YYZ-JFK (4h)
        $YYZ_JFK = Flight::createFlight("AC","304","YYZ","07:35","JFK","10:05",400.23);
        $JFK_YYZ = Flight::createFlight("AC","304","JFK","11:30","YYZ","19:11",420.63);

        //AT:YUL-YYZ (5h)
        $YUL_YYZ = Flight::createFlight("AT","305", "YUL", "13:30", "YYZ", "15:00", 500.50);
        $YYZ_YUL = Flight::createFlight("AT","305", "YYZ", "19:00", "YUL", "20:30", 510.00);

        //AF:YUL-CDG (6h)
        $YUL_CDG = Flight::createFlight("AF","306", "YUL", "22:25", "CDG", "06:25", 600.00);
        $CDG_YUL = Flight::createFlight("AF","306", "CDG", "14:25", "YUL", "17:25", 605.60);

        //AF:JFK-CDG (7h)
        $JFK_CDG = Flight::createFlight("AF","307","JFK","07:35","CDG","10:05",700.05);
        $CDG_JFK = Flight::createFlight("AF","307","CDG","11:30","JFK","19:11",720.00);


        return [
            'YUL_JFK' => $YUL_JFK,
            'JFK_YUL' => $JFK_YUL,
            'YUL_YVR' => $YUL_YVR,
            'YVR_YUL' => $YVR_YUL,
            'YYZ_JFK' => $YYZ_JFK,
            'JFK_YYZ' => $JFK_YYZ,
            'YUL_YYZ' => $YUL_YYZ,
            'YYZ_YUL' => $YYZ_YUL,
            'YUL_CDG' => $YUL_CDG,
            'CDG_YUL' => $CDG_YUL,
            'JFK_CDG' => $JFK_CDG,
            'CDG_JFK' => $CDG_JFK
        ];
    }

    public static function createFlight($airline, $number, $departure_airport, $departure_time, $arrival_airport, $arrival_time, $price)
    {
        $flight = new \stdClass();
        $flight->airline = $airline;
        $flight->number = $number;
        $flight->departure_airport = $departure_airport;
        $flight->departure_time = $departure_time;
        $flight->arrival_airport = $arrival_airport;
        $flight->arrival_time = $arrival_time;
        $flight->price = $price;

        return $flight;
    }
}
