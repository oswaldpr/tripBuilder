<?php
use App\Models\Airport;

/** @var  $stopoverList */

$nbStopover = 0;
$stopoverList = $stopoverList ?? [];
$airports = Airport::getAirportSelectList();
?>
<div id="stopover-list">
    <div id="stopover-list-content">
        @foreach($stopoverList as $index => $stopover)
            @include('templates.newStopover', ['nbStopover' => $index, 'airports' => $airports, 'selected' => $index])
            <?php $nbStopover++; ?>
        @endforeach
    </div>
    <input type="hidden" id="nb-stopover" value="<?php echo $nbStopover; ?>" name="nb-stopover">
</div>
