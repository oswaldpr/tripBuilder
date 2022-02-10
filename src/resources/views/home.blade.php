<?php

/** @var  array $type */
/** @var  array $airports */

?>
@extends('templates.app')

@section('content')
    <div class="homepage">
        <h1 class="text-center">Welcome</h1>
        @include('templates.search', ['title' => 'Search a flight trip', 'type' => $type, 'airports' => $airports])
    </div>
@overwrite

