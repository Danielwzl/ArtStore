<?php
/*
 * search if same item in favorite list
 */
function isExistInFav($id, $type)
{
    if(!isset($_SESSION['favorite'])) $_SESSION['favorite'] = new FavoriteItem();
    return in_array($id, $_SESSION['favorite']->getList($type));
}

/*
 * same thing in cart
 */
function isExistinCart($id, $type)
{
    if(!isset($_SESSION['cart'])) $_SESSION['cart'] = array();
    foreach($_SESSION['cart'] as $item)
    {
        $target = $item->isSameSet($id);
        if($target != null) return $item;
    }
    return null;
}
?>