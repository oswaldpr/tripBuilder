<?php

namespace App\Models;

class StraightFlightTrip
{
    /** @var $flights */
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

            $flightWithUpdatedDates = self::getFlightArrayWithUpdateDates($flightTripArray);
            $totalDuration = self::setTotalDuration($flightWithUpdatedDates);
            $this->flights = $flightWithUpdatedDates;
            $this->flightTitle = $flightTitle;
            $this->totalDuration = $totalDuration;
            $this->price = $price;
            $flightTrip = $this;
        }

        return $flightTrip;
    }

    private static function getFlightArrayWithUpdateDates(array $flightTripArray)
    {
        /** @var  Flight[] $flightTripArray */
        $newFlightArray = $flightTripArray;
        $hasMultipleFlights = count($flightTripArray) > 1;
        if($hasMultipleFlights){
            $newFlightArray = [current($flightTripArray)];
            for($i=1; $i < count($flightTripArray); $i++){
                $previousFlight = $flightTripArray[$i-1];
                $previousArrivalDateTime = $previousFlight->arrivalDateTime;
                $minimumTimeToFlightAgain = $previousArrivalDateTime->modify('+2 hours');
                $thisFlight = $flightTripArray[$i];
                $thisDepartureDateTime = $thisFlight->departureDateTime;
                $canMatch = $minimumTimeToFlightAgain < $thisDepartureDateTime;
                if(!$canMatch){
                    $thisFlight->departureDateTime->modify('+1 day');
                    $thisFlight->arrivalDateTime->modify('+1 day');
                    $thisFlight->delayedDay = $thisFlight->delayedDay + 1;
                }
                $newFlightArray[] = $thisFlight;
            }
        }

        return $newFlightArray;
    }

    private static function setTotalDuration(array $flightTripArray)
    {
        $firstFlight = current($flightTripArray);
        $endFlight = end($flightTripArray);

        $departureDateTime = $firstFlight->departureDateTime;
        $arrivalDateTime = $endFlight->arrivalDateTime;

        $delayed = 0;
        foreach ($flightTripArray as $flight){
            $delayed = $delayed + $flight->delayedDay;
        }

        $interval = $departureDateTime->diff($arrivalDateTime);
        return $interval->format('%h hours');
    }

}
