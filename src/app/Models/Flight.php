<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['airline', 'number', 'departure_airport', 'departure_time', 'arrival_airport', 'arrival_time', 'price'];


    public function airlineDef()
    {
        return $this->belongsTo(Airline::class);
    }

    public function departureAirport()
    {
        return $this->belongsTo(Airport::class);
    }

    public function arrivalAirport()
    {
        return $this->belongsTo(Airport::class);
    }


    public static function getFlightList()
    {
        //AT:YUL-JFK (2h)
        $YUL_JFK = self::createFlight("AT","302","YUL","07:35","JFK","10:05",200.23);
        $JFK_YUL = self::createFlight("AT","302","JFK","11:30","YUL","19:11",220.63);

        //AC:YUL-YVR (3h)
        $YUL_YVR = self::createFlight("AC","303","YUL","07:35","YVR","10:05",300.23);
        $YVR_YUL = self::createFlight("AC","303","YVR","11:30","YUL","19:11",330.63);

        //AC:YYZ-JFK (4h)
        $YYZ_JFK = self::createFlight("AC","304","YVZ","07:35","JFK","10:05",400.23);
        $JFK_YYZ = self::createFlight("AC","304","JFK","11:30","YVZ","19:11",420.63);

        //AT:YUL-YVZ (5h)
        $YUL_YYZ = self::createFlight("AT","305", "YUL", "13:30", "YVZ", "15:00", 500.50);
        $YYZ_YUL = self::createFlight("AT","305", "YVZ", "19:00", "YUL", "20:30", 510.00);

        //AF:YUL-CDG (6h)
        $YUL_CDG = self::createFlight("AF","306", "YUL", "22:25", "CDG", "06:25", 600.00);
        $CDG_YUL = self::createFlight("AF","306", "CDG", "14:25", "YUL", "17:25", 605.60);

        //AF:JFK-CDG (7h)
        $JFK_CDG = self::createFlight("AF","307","JFK","07:35","CDG","10:05",700.05);
        $CDG_JFK = self::createFlight("AF","307","CDG","11:30","JFK","19:11",720.00);


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
        //DO THIS RIGHT AFTER FILLING AIRLINE AND AIRPORT DBs
        //Match these ids value with the appropriates values stored in the db.
        $airlines = array(
            'AC' => 1,
            'AF' => 3,
            'AT' => 2,
        );
        $airports = array(
            'YUL' => 3,
            'YVR' => 5,
            'YVZ' => 1,
            'JFK' => 4,
            'CDG' => 2
        );

        $airline_id = $airlines[$airline];
        $departure_airport_id = $airports[$departure_airport];
        $arrival_airport_id = $airports[$arrival_airport];

        $flight = new \stdClass();
        $flight->airline = $airline;
        $flight->number = $number;
        $flight->departure_airport = $departure_airport;
        $flight->departure_time = $departure_time;
        $flight->arrival_airport = $arrival_airport;
        $flight->arrival_time = $arrival_time;
        $flight->price = $price;
        $flight->airline_id = $airline_id;
        $flight->departure_airport_id = $departure_airport_id;
        $flight->arrival_airport_id = $arrival_airport_id;

        return $flight;
    }

    public function buildAdditionalFields($date)
    {
        $airlineList = Airline::query()->get();
        foreach ($airlineList as $airline) {
            if($this->airline === $airline->code){
                $airlineDefinition = $airline;
                break;
            }
        }

        $airportList = Airport::query()->get();
        foreach ($airportList as $airport) {
            if($this->departure_airport === $airport->code){
                $departureDefinition = $airport;
            }
            if($this->arrival_airport === $airport->code){
                $arrivalDefinition = $airport;
            }
        }

        $departureDate = self::getDateTime($date, $this->departure_time, $departureDefinition->timezone);
        $arrivalDate = self::getDateTime($date, $this->arrival_time, $arrivalDefinition->timezone);

        $this->airlineDefinition = $airlineDefinition;
        $this->departureAirportDefinition = $departureDefinition;
        $this->arrivalAirportDefinition = $arrivalDefinition;
        $this->departureDateTime = $departureDate;
        $this->arrivalDateTime = $arrivalDate;

        return $this;
    }

    private static function getDateTime($date, $time, $timezone)
    {
        $dateTime = $date . ' ' . $time;
        return new DateTime( $dateTime, new DateTimeZone($timezone) );
    }
}
