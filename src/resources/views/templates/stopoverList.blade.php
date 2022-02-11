<?php
use App\Models\Airport;

/** @var  int $nbStopover */
/** @var  $stopoverList */

$nbStopover = $nbStopover ?? 0;
$stopoverList = $stopoverList ?? [];
$airports = Airport::getAirportSelectList();
?>
<div id="stopover-list">
    @foreach($stopoverList as $index => $stopover)
        @include('templates.newStopover', ['nbStopover' => $index, 'airports' => $airports]);
        <?php $nbStopover++; ?>
    @endforeach
    <input type="hidden" id="nb-stopover" value="<?php echo $nbStopover; ?>" name="nb-stopover">
</div>
