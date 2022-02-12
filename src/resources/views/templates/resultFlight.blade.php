<?php
use App\Models\Flight;

/** @var  Flight $flight */

$airlineDefinition = $flight->airlineDefinition;
$departureDefinition = $flight->departureAirportDefinition;
$arrivalDefinition = $flight->arrivalAirportDefinition;

$delayedDayStr = $flight->delayedDay ? '+' . $flight->delayedDay : '';
$duration = $flight->duration;
$departureDateTime = $flight->departureDateTime;
$departureDate = Flight::getDateStr($departureDateTime);
$departureTime = Flight::getDateStr($departureDateTime);

$arrivalDateTime = $flight->arrivalDateTime;
$arrivalDate = Flight::getDateStr($arrivalDateTime);
$arrivalTime = Flight::getDateStr($arrivalDateTime);

$airlineName = $airlineDefinition->name . ' (' . $airlineDefinition->code . ')';
$flightName = $flight->airline . $flight->number;

$departureTime = $flight->departure_time;
$arrivalTime = $flight->arrival_time;
$departureAirportName = $departureDefinition->city . ' - ' . $departureDefinition->name . ' (' . $departureDefinition->code . ')';
$arrivalAirportName = $arrivalDefinition->city . ' - ' . $arrivalDefinition->name . ' (' . $arrivalDefinition->code . ')';
?>

<div class="result-flight-step-content">
    <div class="flight-info">
        <h5 class="single-info-title">Flight</h5>
        <div class="single-info-content">
            @include('templates.elements.displayElement', ['label' => 'Airline', 'value' => $airlineName])
            @include('templates.elements.displayElement', ['label' => 'Flight number', 'value' => $flightName])
        </div>
    </div>

    <div class="departure-info">
        <h5 class="single-info-title">Departure</h5>
        <div class="single-info-content">
            @include('templates.elements.displayElement', ['label' => 'Date', 'value' => $departureDate])
            @include('templates.elements.displayElement', ['label' => 'Time', 'value' => $departureTime])
            @include('templates.elements.displayElement', ['label' => 'Airport', 'value' => $departureAirportName])
        </div>
    </div>

    <div class="arrival-info">
        <h5 class="single-info-title">Arrival</h5>
        <div class="single-info-content">
            @include('templates.elements.displayElement', ['label' => 'Date', 'value' => $arrivalDate])
            @include('templates.elements.displayElement', ['label' => 'Time', 'value' => $arrivalTime])
            @include('templates.elements.displayElement', ['label' => 'Airport', 'value' => $arrivalAirportName])
        </div>
    </div>

</div>

