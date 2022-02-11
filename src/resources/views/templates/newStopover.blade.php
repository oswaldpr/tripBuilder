<?php

/** @var  int $nbStopover */
/** @var  array $airports */

use App\Models\Airport;

$stopover = $nbStopover + 1;
$stopoverName = 'stopover[' . $stopover . ']';
$stopoverLabel = 'Stopover' . ($stopover === 1 ? '' : ' ' . $stopover);

$airports = Airport::getAirportSelectList();

?>
<div class="single-stopover single-stopover-<?php echo $stopover; ?>" data-stopover="<?php echo $stopover; ?>">
    @include('templates.elements.selectElement', ['name' => $stopoverName, 'label' => $stopoverLabel, 'options' => $airports])
    <button type="button" class="close remove-stopover" aria-label="Close">
        <span class="" aria-hidden="true">x</span>
    </button>
</div>
