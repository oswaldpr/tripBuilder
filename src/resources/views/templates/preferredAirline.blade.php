<?php

/** @var  int $nbStopover */
/** @var  array $airports */

use App\Models\Airline;

$airlines = Airline::getAirplineSelectList();
?>
<div id="preferred-airline-select">
    @include('templates.elements.selectElement', ['name' => 'airline', 'label' => 'Choose an airline', 'options' => $airlines])
</div>
