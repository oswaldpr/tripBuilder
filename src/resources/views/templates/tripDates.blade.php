<?php
/** @var  string $type */

$type = $type ?? '';
?>
<div id="trip-dates" class="row">
    <p id="departureDate" class="col-6">Departure date: <input type="text" name="departureDate" class="trip-datepicker"/></p>
    @if($type === 'round-trip')
        <p id="returnDate" class="col-6">Return date: <input type="text" name="returnDate" class="trip-datepicker"/></p>
    @endif
</div>
