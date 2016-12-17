<?php
include_once 'classes/OneSetItem.class.php';
include_once 'classes/FavoriteItem.class.php';

/*
 * load the session when page starts
 */
if(!isset($_SESSION)) session_start();

/*
 * calculate the number of item in each list
 */
function update($token)
{
    $sum = 0;
    if(isset($_SESSION[$token]) & !empty($_SESSION[$token]))
    {
        if($token == 'favorite')
            $sum = $_SESSION['favorite']->getQty();
            else
            {
                foreach($_SESSION[$token] as $item)
                {
                    $sum += $item->getSetQty();
                }
            }
    }
    if($sum > 0) return $sum;
}
?>