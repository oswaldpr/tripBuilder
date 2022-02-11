<?php
/** @var  string $name */
/** @var  string $label */
/** @var  string $selected */
/** @var  array $options */

$selected = $selected ?? '';
?>
<div class="form-group row element-wrapper element-wrapper-<?php echo $name; ?>">
    <div class="col-12 col-form-label label label-wrapper label-wrapper-<?php echo $name; ?>">
        <label for=<?php echo $name; ?>><?php echo $label; ?> </label>
    </div>
    <div class="col-12 input-radio-wrapper controls controls-<?php echo $name; ?>">
        <?php
        foreach ($options as $optionKey => $optionValue) {
            $selectedStr = $selected === $optionKey ? 'checked' : '';
            echo '<div class="input-radio-element">';
            echo '<input type="radio" class="input-' . $name . '" name="' . $name . '" value="' . $optionKey . '" ' . $selectedStr . '/>';
            echo '<label for="' . $name . '">' . $optionValue . '</label>';
            echo '</div>';
        }
        ?>
    </div>
</div>
