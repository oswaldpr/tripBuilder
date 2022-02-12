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
        $flightTrip = null;
        $formData = RequestController::getFormDataParameters($request);

        $flightTripSteps = self::buildFlightTripSteps($formData);
        if($flightTripSteps){
            $flightTripArray = self::buildStraightFlight($flightTripSteps, $formData['departureDate'], true);

            $type = $formData['type'];
            $returnFlightTrip = $type === 'round-trip' ? array_reverse($flightTripSteps) : [];
            $returnFlightTripArray = array();
            if($returnFlightTrip){
                $returnFlightTripArray = self::buildStraightFlight($returnFlightTrip, $formData['returnDate'], true);
            }

            $flightTrip = new FlightTrip($flightTripArray, $returnFlightTripArray);
        }

        return view('templates.results', ['title' => 'Results', 'flightTrip' => $flightTrip]);
    }

    private static function buildStraightFlight($flightTrip, $date, $allowCorrespondences = false)
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

            if($thisFlight){
                $flightTripArray[] = $thisFlight->buildAdditionalFields($date);
            } elseif($allowCorrespondences) {
                $departureFlightList = Flight::query()->select('id', 'departure_airport', 'arrival_airport')
                    ->where('departure_airport', $thisDeparture)
                    ->get()->toArray();
                $alternateDepList = self::getAlternateDepartureFlightID($departureFlightList);
                $depList = self::buildAirportsFlightIDList($departureFlightList);
                $arrivalFlightIDArr = Flight::query()->select('id', 'departure_airport', 'arrival_airport')
                    ->where('arrival_airport', $thisArrival)
                    ->whereIn('departure_airport', $alternateDepList)
                    ->get()->toArray();
                $arrList = self::buildAirportsFlightIDList($arrivalFlightIDArr);
                $arrOptionList = self::builOptionTripList($depList, $arrList);
                foreach ($arrOptionList as $flightOption) {
                    $flightIDDetail = Flight::query()->where('id', $flightOption->flightID)->first();
                    $flightTripArray[] = $flightIDDetail->buildAdditionalFields($date);
                }
            }

            $nextFlightIIndex = $arrivalIndex + 1;
            if(!isset($flightTrip[$nextFlightIIndex])){
                break;
            }
        }

        return $flightTripArray;
    }

    private static function getAlternateDepartureFlightID($queryResult = array())
    {
        $idList = [];
        foreach($queryResult as $flight){
            $idList[$flight['id']] = $flight['arrival_airport'];
        }

        return $idList;
    }

    private static function buildAirportsFlightIDList($queryResult = array())
    {
        $currentList = [];
        foreach($queryResult as $flight){
            $trip = new \stdClass();
            $trip->departure_airport = $flight['departure_airport'];
            $trip->arrival_airport = $flight['arrival_airport'];
            $trip->flightID = $flight['id'];
            $currentList[] = $trip;
        }

        return $currentList;
    }

    private static function builOptionTripList($depList = array(), $arrList = array())
    {
        //Make sure each flight option has a valid correspondence airport
        $tripOptionList = [];
        foreach ($depList as $depFlight){
            foreach ($arrList as $arrFlight){
                if($arrFlight->departure_airport === $depFlight->arrival_airport){
                    $tripOptionList[] = $depFlight;
                    $tripOptionList[] = $arrFlight;
                }
            }
        }
        return $tripOptionList;
    }
}
