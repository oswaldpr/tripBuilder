<?php

/** @var  int $nbStopover */
/** @var  array $airports */

use App\Models\Airport;

$stopover = $nbStopover + 1;
$stopoverName = 'stopover_airport[' . $stopover . ']';
$stopoverLabel = 'Stopover' . ($stopover === 1 ? '' : ' ' . $stopover);

$airports = Airport::getAirportSelectList();

?>
<div class="single-stopover">
    @include('templates.selectElement', ['name' => $stopoverName, 'label' => $stopoverLabel, 'options' => $airports])
    <span class="remove-stopover">x</span>
</div>
