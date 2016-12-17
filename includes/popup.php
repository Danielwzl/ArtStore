<?php

function popup($type, $content)
{
    echo '<div class="ui ' . $type . ' message">
            <i class="close icon"></i>
            <div class="header">' . $content . '</div></div>';
}
?>