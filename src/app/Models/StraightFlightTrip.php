<?php

namespace App\Models;

class StraightFlightTrip
{
    /** @var  $flights */
    public $flights;

    /** @var  $returnFlight */
    public $totalDuration;

    /** @var  float $price */
    public $price;

    public function __construct(array $flightTripArray = array())
    {
        $flightTrip = null;
        if(!empty($flightTripArray)){
            $price = 0;
            $totalDuration = 0;
            foreach ($flightTripArray as $flightTrip) {
                $price = $price + $flightTrip->price;
            }

            $this->flights = $flightTripArray;
            $this->totalDuration = $totalDuration;
            $this->price = $price;
            $flightTrip = $this;
        }

        return $flightTrip;
    }

}
