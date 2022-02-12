<?php

namespace App\Models;

class StraightFlightTrip
{
    /** @var  $flights */
    public $flights;

    /** @var  $totalDuration */
    public $totalDuration;

    /** @var string $flightTitle */
    public $flightTitle;

    /** @var  float $price */
    public $price;

    public function __construct(array $flightTripArray = array())
    {
        $flightTrip = null;
        if(!empty($flightTripArray)){
            $price = 0;
            $totalDuration = 0;
            $flightTitle = '';
            $isOnlyOneFlight = count($flightTripArray) === 1;
            foreach ($flightTripArray as $flightTrip) {
                $price = $price + $flightTrip->price;
                if($flightTitle === ''){
                    $flightTitle = $flightTrip->departureAirportDefinition->city;
                    if($isOnlyOneFlight){
                        $flightTitle = $flightTitle . ' to ' . $flightTrip->arrivalAirportDefinition->city;
                    }
                } else {
                    $flightTitle = $flightTitle . ' to ' . $flightTrip->arrivalAirportDefinition->city;
                }
            }

            $this->flights = $flightTripArray;
            $this->flightTitle = $flightTitle;
            $this->totalDuration = $totalDuration;
            $this->price = $price;
            $flightTrip = $this;
        }

        return $flightTrip;
    }

}
