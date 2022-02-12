<?php
/** @var  string $label */
/** @var  mixed $value */

$label = $label ?? null;
?>

<div class="result-field row">
    @if($label)
        <span class="col-2 col-form-label label labelWrapper">
        <label><b><?php echo $label; ?></b>:</label>
    </span>
    @endif
    <span class="col-10 resultWrap controls">
        <?php echo $value; ?>
    </span>
</div>

