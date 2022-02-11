<?php

/** @var  array $type */
/** @var  array $airports */
/** @var  stdClass $trip */

$trip = $trip ?? null;
?>

@extends('templates.sectionWithTitle')
@section('sectionWithTitle-content')
    <div class="search-result-list-content">
        @if($trip)
            @include('templates.results', ['title' => 'Results', 'trip' => $trip])
        @else
            Sorry no results! Please try with other parameters
        @endif
    </div>
@overwrite

