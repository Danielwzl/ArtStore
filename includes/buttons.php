<?php

function generateButtons($id, $labeled, $right, $cartButtonName, $likeButtonName, $type, $color)
{
    generateCartButtons($id, $labeled, $cartButtonName, true, '');
    generateFavoriteButtons($id, $labeled, $right, $likeButtonName, $type, $color);
}

function generateFavoriteButtons($id, $labeled, $right, $likeButtonName, $type, $color)
{
    $message = $color == '' ? 'Add item to Favorite' : 'View Favorite list';
    echo '<a href="addToFavorite.php?id=' . $id . '&name=' . $type . '&action=add">
        <div data-tooltip="' . $message . '" data-position="bottom center" class="ui ' . $right . ' ' . $labeled . ' icon button">
        <i class="' . $color . ' heart icon"></i>' . $likeButtonName . '</div></a>';
}

/**
 * PARAM
 * $withURL: browse-painting and single-painting pages have different addToCart functionalities
 * $form: which form to be submitted
 */
function generateCartButtons($id, $labeled, $cartButtonName, $withURL, $form)
{
    $message = $cartButtonName == 'Replace in Cart' ? 'Replace it to existing one' : 'Add item to cart';
    $button = $withURL ? '<a href="addToCart.php?id=' . $id . '&action=add&from=browse-painting">
                <button data-tooltip="' . $message . '" data-position="bottom right" class="ui ' . $labeled . ' orange icon button">
            <i class="add to cart icon"></i>' . $cartButtonName . '</button></a>' : 
            '<button data-tooltip="' . $message . '" data-position="bottom right" form="' . $form . '" name="id" value="' . $id . '" type="submit" class="ui ' . $labeled . ' orange icon button">
            <i class="add to cart icon"></i>' . $cartButtonName . '</button>';
    echo $button;
}

function generateEmptyButtons($php, $type)
{
    echo '<a href="' . $php . '.php?name=' . $type . '&action=empty">
        <div data-tooltip="Empty the list" data-position="bottom center" class="negative ui bottom attached button" tabindex="0">EMPTY</div></a>';
}

function generateRemoveButtons($key, $php, $type)
{
    return '<a href="' . $php . '.php?key=' . $key . '&name=' . $type . '&action=remove">
         <div data-tooltip="Remove from list" data-position="top" class="ui tiny blue button">Remove</div></a>';
}

function generateUpdateButtons()
{
    return '<button data-tooltip="Update detail of order" data-position="top center" class="ui icon button "type="submit" name="action" value="update">Update</button>';
}

function generateContinueShoppingButton()
{
    echo '<button name="action" value="updateToHome" type="submit" form="cartForm" data-tooltip="Back to main page"
								data-position="bottom right" 
        id="conShopping" class="positive ui bottom attached button" tabindex="0">
								Continue Shopping</button>';
}

?>