<?php

/** @var  array $type */
/** @var  array $airports */
?>
@extends('templates.sectionWithTitle')
@section('sectionWithTitle-content')
    <form id="search-trip-form" method="post">
        @csrf <!-- {{ csrf_field() }} -->
        @include('templates.elements.radioElement', ['name' => 'type', 'label' => 'Flight type', 'options' => $type])
        @include('templates.tripDates')
        <div class="clearfix"></div>
        <div class="row col-12">
            <div class="airport-selection col-10">
                @include('templates.elements.selectElement', ['name' => 'departure_airport', 'label' => 'Departure airport', 'options' => $airports])
                @include('templates.stopoverList')
                @include('templates.elements.selectElement', ['name' => 'arrival_airport', 'label' => 'Arrival airport', 'options' => $airports])
            </div>
            <div class="add-stopover-btn-wrap col-2"></div>
        </div>

    <div class="search-trip-submit-button-group btn-group-justified text-center">
        <button type="button" id="searchFlight" class="btn btn-default" @click="searchFlight()">
            <?php echo __('Search')?>
        </button>
    </div>
    </form>
@overwrite

