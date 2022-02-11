<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function getAirlineList(){
        $AC = self::createAirline('AC', 'Air Canada');
        $AF = self::createAirline('AF','Air France');
        $AT = self::createAirline('AT', 'Air Transat');

        return array(
            'AC' => $AC,
            'AF' => $AF,
            'AT' => $AT
        );
    }

    public static function createAirline($code, $name)
    {
        $airline = new \stdClass();
        $airline->code = $code;
        $airline->name = $name;

        return $airline;
    }
}
