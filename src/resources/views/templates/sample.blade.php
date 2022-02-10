@extends('templates.sectionWithTitle')
@section('sectionWithTitle-content')
    <select class="form-control UnitType no-search select2-hidden-accessible" id="address_unitType" name="address[unitType]" data-model="address" data-name="address" tabindex="-1" aria-hidden="true">
        <option value="">--</option>
        <option value="1" selected="">Apartment</option>
        <option value="2">Suite</option>
        <option value="3">Unit</option>
    </select>
    <div class="btn-group-justified">
        <button type="button" class="btn btn-cancel " data-dismiss="modal"><?php echo __('Cancel')?></button>
        <button type="button" id="proceed" class="btn btn-default pull-right" @click="proceed()">
        <?php echo __('Proceed')?>
    </button>
    </div>
@overwrite

