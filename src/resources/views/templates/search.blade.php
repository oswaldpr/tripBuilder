<?php

/** @var  array $type */
/** @var  array $airports */
?>
@extends('templates.sectionWithTitle')
@section('sectionWithTitle-content')
    <form id="search-trip-form" method="post">
        @csrf <!-- {{ csrf_field() }} -->
        @include('templates.elements.radioElement', ['name' => 'type', 'label' => 'Flight type', 'options' => $type, 'selected' => 'one-way'])
        <div class="clearfix"></div>
        <div class="row col-12">
            <div class="airport-selection col-10">
                @include('templates.elements.selectElement', ['name' => 'departure_airport', 'label' => 'Departure airport', 'options' => $airports])
                @include('templates.stopoverList')
                @include('templates.elements.selectElement', ['name' => 'arrival_airport', 'label' => 'Arrival airport', 'options' => $airports])
            </div>
            <div class="destination-actions col-2">
                <button type="button" id="add-stopover" class="btn btn-default pull-right">
                    <?php echo __('Add stopover')?>
                </button>
            </div>
        </div>

    <div class="search-trip-submit-button-group btn-group-justified text-center">
        <button type="button" class="btn btn-default">
            <?php echo __('Clear')?>
        </button>
        <button type="button" id="search" class="btn btn-default" @click="search()">
            <?php echo __('Search')?>
        </button>
    </div>
    </form>
@overwrite

