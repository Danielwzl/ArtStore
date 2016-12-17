<?php

/*
 * return name of frames glasses and matts
 */
function selectedItem($data)
{
    return $selected = ($temp = $data->getName()) == null ? 'None' : $temp;
}

function displayTopOption($selectedSetting, $id, $price)
{
    $id = $id >= 0 ? $id : '';
    echo '<option value="' . $id . '|' . $price . '" style="display: none;">' . $selectedSetting . '</option>';
}

?>