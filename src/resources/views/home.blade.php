<?php
use App\Models\FlightTrip;

/** @var  array $type */
/** @var  array $airports */
/** @var  FlightTrip $flightTrip */


$flightTrip = $flightTrip ?? null;
?>
@extends('templates.app')

@section('content')
    <div class="homepage">
        <h1 class="text-center">Welcome</h1>
        @include('templates.search', ['title' => 'Search a flight trip', 'type' => $type, 'airports' => $airports])
        <div id="search-result-list">
            @if($flightTrip)
                @include('templates.results', ['title' => 'Results', 'flightTrip' => $flightTrip])
            @endif
        </div>
    </div>
@overwrite

