<?php
use App\Models\Flight;

/** @var  Flight $flight */

$airlineDefinition = $flight->airlineDefinition;
$departureDefinition = $flight->departureAirportDefinition;
$arrivalDefinition = $flight->arrivalAirportDefinition;
$departureDate = $flight->departureDateTime;
$arrivalDate = $flight->arrivalDateTime;

$airlineName = $airlineDefinition->name . ' (' . $airlineDefinition->code . ')';
$flightName = $flight->airline . $flight->number;

$departureTime = $flight->departure_time;
$arrivalTime = $flight->arrival_time;
$departureAirportName = $departureDefinition->city . ' - ' . $departureDefinition->name . ' (' . $departureDefinition->code . ')';
$arrivalAirportName = $arrivalDefinition->city . ' - ' . $arrivalDefinition->name . ' (' . $arrivalDefinition->code . ')';
?>

<div class="result-flight-step-content">
    @include('templates.elements.displayElement', ['label' => 'Airline', 'value' => $airlineName])
    @include('templates.elements.displayElement', ['label' => 'Flight', 'value' => $flightName])

{{--    @include('templates.elements.displayElement', ['label' => 'Departure date', 'value' => $departureDate])--}}
    @include('templates.elements.displayElement', ['label' => 'Departure airport', 'value' => $departureAirportName])

{{--    @include('templates.elements.displayElement', ['label' => 'Arrival date', 'value' => $arrivalDate])--}}
    @include('templates.elements.displayElement', ['label' => 'Arrival airport', 'value' => $arrivalAirportName])
</div>

