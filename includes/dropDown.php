<?php

function outputDropdownList($stmt, $idType)
{
   
    foreach($stmt as $row)
    {
        $price = $idType == 'MattID' ? 10 : $row['Price'];
        if($row['Title'] != '[None]') echo '<option value=' . $row[$idType] . '|' . number_format((int)$price) . '>' . $row['Title'] . '</option>';
        
    }
}
?>