<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\FlightTrip;
use Illuminate\Http\Request;
use App\Models\Airport;

class TripController extends Controller
{
    public function index()
    {
        $airports = Airport::getAirportSelectList();
        $type = ['one-way' => 'One way', 'round-trip' => 'Round trip', 'multi-destination' => 'Multi destination'];

        return view('home', ['type' => $type, 'airports' => $airports]);
    }

    public function getAddStopoverBtn()
    {
        return view('templates.addStopoverBtn');
    }

    public function addStopover(Request $request)
    {
        $view = '';
        $nbStopover = (int)$request->nbStopover;
        if($nbStopover <= 5){
            $view = view('templates.newStopover', ['nbStopover' => $nbStopover]);
        }
        return $view;
    }

    public function removeStopover(Request $request)
    {
        $view = '';
        $stopoverToRemove = (int)$request->stopover;
        $formData = RequestController::getFormDataParameters($request);
        $stopoverArray = $formData['stopover'];
        $newArr = [];
        foreach ($stopoverArray as $index => $stopover) {
            if ($index !== $stopoverToRemove) {
                $newArr[] = $stopover;
            }
        }

        if($stopoverToRemove){
            $view = view('templates.stopoverList', ['stopoverList' => $newArr]);
        }
        return $view;
    }

    public static function buildFlightTripSteps($formData)
    {
        $departure = $formData['departure_airport'];
        $arrival = $formData['arrival_airport'];
        $stopoverList = $formData['stopover'] ?? [];

        $trip = [$departure];
        foreach ($stopoverList as $stopover) {
            $trip[] = $stopover;
        }
        $trip[] = $arrival;

        return $trip;
    }

    public static function searchFlight(Request $request)
    {
        $formData = RequestController::getFormDataParameters($request);

        $flightTripSteps = self::buildFlightTripSteps($formData);
        $flightTripArray = self::buildStraightFlight($flightTripSteps);

        $type = $formData['type'];
        $returnFlightTrip = $type === 'round-trip' ? array_reverse($flightTripSteps) : [];
        $returnFlightTripArray = array();
        if($returnFlightTrip){
            $returnFlightTripArray = self::buildStraightFlight($returnFlightTrip);
        }

        $flightTrip = new FlightTrip($flightTripArray, $returnFlightTripArray);

        return view('templates.results', ['trip' => $flightTrip]);
    }

    private static function buildStraightFlight($flightTrip = array())
    {
        $flightTripArray = [];
        foreach($flightTrip as $index => $flight){
            $arrivalIndex = $index + 1;
            $thisDeparture = $flight;
            $thisArrival = $flightTrip[$arrivalIndex];
            $thisFlight = Flight::query()
                ->where('departure_airport', $thisDeparture)
                ->where('arrival_airport', $thisArrival)
                ->first();
            $thisFlightDetail = Flight::createFlight($thisFlight->airline, $thisFlight->number, $thisFlight->departure_airport, $thisFlight->departure_time, $thisFlight->arrival_airport, $thisFlight->arrival_time, $thisFlight->price);
            $flightTripArray[] = $thisFlightDetail;

            $nextFlightIIndex = $arrivalIndex + 1;
            if(!isset($flightTrip[$nextFlightIIndex])){
                break;
            }
        }

        return $flightTripArray;
    }
}
