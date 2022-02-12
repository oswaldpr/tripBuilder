<?php
use App\Models\FlightTrip;


/** @var  FlightTrip $flightTrip */

$flightTrip = $flightTrip ?? null;
?>

@extends('templates.sectionWithTitle')
@section('sectionWithTitle-content')
    <div class="search-result-list-content">
        @if($flightTrip)
            <div id="result-departure">
                <h3>{{ $flightTrip->straightFlight->flightTitle }}</h3>
                @foreach($flightTrip->straightFlight->flights as $index => $currentFlight)
                    <div class="result-single-flight">
                        @include('templates.resultFlight', ['flight' => $currentFlight])
                    </div>
                @endforeach
            </div>
            @if($flightTrip->returnFlight)
                <div id="result-return">
                    <h3>{{ $flightTrip->returnFlight->flightTitle }}</h3>
                    @foreach($flightTrip->returnFlight->flights as $currentFlight)
                        <div class="result-single-flight">
                            @include('templates.resultFlight', ['flight' => $currentFlight])
                        </div>
                    @endforeach
                </div>
            @endif
            <h3>Price: <b>{{ $flightTrip->totalPrice }}</b></h3>
        @else
            Sorry, no results for your search!
        @endif
    </div>
@overwrite

