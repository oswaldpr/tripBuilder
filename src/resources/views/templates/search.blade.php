<?php

/** @var  array $type */
/** @var  array $airports */
?>
@extends('templates.sectionWithTitle')
@section('sectionWithTitle-content')
    <form>
        @include('templates.radioElement', ['name' => 'type', 'label' => 'Flight type', 'options' => $type])
        <div class="clearfix"></div>
        <div class="airport-selection">
            @include('templates.selectElement', ['name' => 'departure_airport', 'label' => 'Departure airport', 'options' => $airports])
            <div class="additional-destinations"></div>
            @include('templates.selectElement', ['name' => 'arrival_airport', 'label' => 'Arrival airport', 'options' => $airports])
        </div>

    <div class="btn-group-justified">
        <button type="button" class="btn btn-cancel">
            <?php echo __('Clear')?>
        </button>
        <button type="button" id="search" class="btn btn-default pull-right" @click="search()">
            <?php echo __('Search')?>
        </button>
    </div>
    </form>
@overwrite

