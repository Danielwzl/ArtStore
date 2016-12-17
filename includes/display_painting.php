
<?php

function display($res, $functionName)
{
    $flag = true;
    $cnt = 0;
    foreach($res as $row)
    {
        if($flag) // display header once
        {
            $passed = true;
            $functionName($row);
        }
        displaypaintings($row, $flag, $cnt++);
    }
    echo '</div></div>'; // close tag of ui.row and .ui.gird
}

/**
 * these function are used buy single-painting and single-genre files 
 * to keep page consistent looking
 */
function displaypaintings($row, &$flag, $cnt)
{
    if($flag) // do it one time and set it back to false
    {
        echo '<div class="ui centered grid">';
        echo '<div class="twelve wide column"><h2 class="ui header">Paintings</h2><div class="ui divider"></div></div>';
        $flag = false;
    }
    if($cnt % 6 == 0)
    {
        if($cnt != 0) echo '</div>'; // close previous tag
        echo '<div class="ui six column row">';
    }
    echo '<div class="two wide column"><a href="single-painting.php?id=' . $row['PaintingID'] . '">
          <img class="thumbnail" src="images/art/works/square-medium/' . $row['ImageFileName'] . '.jpg" alt="' . utf8_encode($row['Title']) . '">
              </a></div>';
}

?>