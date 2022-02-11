<?php

/** @var  array $type */
/** @var  array $airports */
/** @var  stdClass $trip */

$trip = $trip ?? null;
?>
@extends('templates.app')

@section('content')
    <div class="homepage">
        <h1 class="text-center">Welcome</h1>
        @include('templates.search', ['title' => 'Search a flight trip', 'type' => $type, 'airports' => $airports])
        <div id="search-result-list">
            @if($trip)
            @include('templates.results', ['title' => 'Results', 'trip' => $trip])
            @endif
        </div>
    </div>
@overwrite

