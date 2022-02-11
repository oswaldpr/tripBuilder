<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function getAirportSelectList()
    {
        $list = self::getAirportList();
        $selectList = array();
        foreach ($list as $item) {
            $selectList[$item->code] = $item->name;
        }
        return $selectList;
    }

    public static function getAirportList()
    {
        $YUL = self::createAirport("YUL", "YMQ", "Pierre Elliott Trudeau International",
            "Montreal","CA","QC",45.457714,-73.749908,"America/Montreal");
        $YVL = self::createAirport("YVL", "YVL", "Vancouver International",
            "Vancouver","CA","BC",49.194698,-123.179192,"America/Vancouver");
        $YVZ = self::createAirport("YVZ", "YTZ", "Toronto Pearson International",
            "Toronto","CA","ON",43.676667,-79.630556,"America/Toronto");
        $JFK = self::createAirport("JFK", "JFK", "John F. Kennedy International",
            "New York","US","NY",40.639722,-73.778889,"America/New_York");
        $CDG = self::createAirport("CDG", "YMQ", "Charles de Gaulle International",
            "Paris","FR","PA",49.009722,2.547778,"europe/paris");

        return array(
            'YUL' => $YUL,
            'YVL' => $YVL,
            'YVZ' => $YVZ,
            'JFK' => $JFK,
            'CDG' => $CDG
        );
    }

    public static function createAirport($code, $city_code, $name, $city, $country_code, $region_code, $latitude, $longitude, $timezone)
    {
        $airport = new \stdClass();
        $airport->code = $code;
        $airport->city_code = $city_code;
        $airport->name = $name;
        $airport->city = $city;
        $airport->country_code = $country_code;
        $airport->region_code = $region_code;
        $airport->latitude = $latitude;
        $airport->longitude = $longitude;
        $airport->timezone = $timezone;

        return $airport;
    }
}
