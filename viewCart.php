<?php
include_once 'classes/OneSetItem.class.php';
include_once 'classes/DropdownDataGateway.class.php';
include 'includes/buttons.php';
include 'includes/dropDown.php';
include 'includes/displayExistingCartItem.php';

/*
 * generate ui for cart page
 */
function output()
{
    $frame = new DropdownDataGateway('Title, FrameID, Price', 'TypesFrames');
    $glass = new DropdownDataGateway('Title, GlassID, Price', 'TypesGlass');
    $matt = new DropdownDataGateway('Title, MattID', 'TypesMatt');
    $frame->setOrderBy(' order by Title ');
    $glass->setOrderBy(' order by Title ');
    $matt->setOrderBy(' order by Title ');
    $frames = $frame->getAll();
    $glasses = $glass->getAll();
    $matts = $matt->getAll();
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])) $_SESSION['cart'] = array();
    $cart = &$_SESSION['cart'];
    outputListOfSets($cart, $frames, $matts, $glasses, count($cart));
    $frame->disconnect();
    $glass->disconnect();
    $matt->disconnect();
}

function outputListOfSets(&$cart, $frames, $matts, $glasses, $numOfSet)
{
    $index = 0;
    $setName = $numOfSet > 1 ? 'sets' : 'set';
    echo '<div class="ui medium centered header">You have <span id="numOfSet">' . $numOfSet . '&nbsp;</span>' . $setName . '&nbsp;of item in the cart</div>';
    foreach($cart as $key => $item)
    {
        $item->updateOrderDetail(); // update detail
        $item->getPainting()->getQty();
        displayOneSetItem($item, $frames, $matts, $glasses, $key, $index++);
    }
}

/*
 * $key: index of each item set in the session
 */
function displayOneSetItem($item, $frames, $matts, $glasses, $key, $index)
{
    $paintingName = utf8_encode($item->getPainting()->getName());
    $qty = $item->getPainting()->getQty();
    $spaces = space(10);
    $frame = $item->getFrame();
    $glass = $item->getGlass();
    $matt = $item->getMatt();
    echo '<div class="ui segment">
            <div class="seven inline fields">
                <div class="ui small header">' . $paintingName . '</div>' . $spaces;
    echo '<a href="single-painting.php?id=' . $item->getPainting()->getId() . '">
        <img src="images/art/works/square-small/' . $item->getPainting()->getImageID() . '.jpg"  alt="' . $paintingName . '"></a>' . $spaces;
    echo '<div class="six wide field"><label>Quantity</label>
            <input class="qty' . $index . '" type="number" name="qty[]" min=1 value=' . $qty . '></div>';
    echo '<div class="six wide field">
            <label>Frame</label>
                <select id="frame' . $index . '" name="Frame[]" class="ui search dropdown">';
    displayTopOption(selectedItem($frame), -1, pricing($frame->getPrice())); // -1 means no need place a value in this option, no change in this select then this id will be empty in querystring
    echo '<option value="-1|0">None</option>'; // when put this none-change item into cart there will be no update for this one
    echo outputDropdownList($frames, 'FrameID'); // option of 'None' is -1, because I dont want to make this value empty when user choose none, it will update
    echo '</select></div>';
    
    echo '<div class="six wide field"><label>Glass</label>
            <select id="glass' . $index . '" name="Glass[]" class="ui search dropdown">';
    displayTopOption(selectedItem($glass), -1, pricing($glass->getPrice()));
    echo '<option value="-1|0">None</option>';
    echo outputDropdownList($glasses, 'GlassID');
    echo '</select></div>';
    
    echo '<div class="six wide field"><label>Matt</label>
            <select id="matt' . $index . '" name="Matt[]" class="ui search dropdown">';
    displayTopOption(selectedItem($matt), -1, pricing($matt->getPrice()));
    echo '<option value="-1|0">None</option>';
    echo outputDropdownList($matts, 'MattID');
    echo '</select><input type="hidden" name="key[]" value="' . $key . '"></div>';
    echo '<input type="hidden" name="action" value="update">';
    echo '<div class="four wide field">';
    echo $spaces . generateRemoveButtons($key, 'addToCart', 'cart');
    echo '</div></div><div class="ui grid "><div class="twelve wide column"></div><div class="four wide column">';
    displayCost($qty, $item, $index);
    echo '</div></div></div><div class="ui divider"></div>';
}

function displayCost($qty, $item, $index)
{
    $painting = $item->getPainting();
    $frame = $item->getFrame();
    $glass = $item->getGlass();
    $matt = $item->getMatt();
    echo '<div class="column">Painting price: $<span id="totalpainting' . $index . '"></span>&nbsp;
        (<span class="unitPrice' . $index . '">' . pricing($painting->getPrice()) . '</span> * 
            <span class="qty' . $index . '">' . $qty . '</span>)</div>';
    
    echo '<div class="column">Frame price: $<span id="totalframe' . $index . '"></span>&nbsp;
        (<span class="unitPrice' . $index . ' frame">' . pricing($frame->getPrice()) . '</span> * 
            <span class="qty' . $index . '">' . $frame->getQty() . '</span>)</div>';
    
    echo '<div class="column">Glass price: $<span id="totalglass' . $index . '"></span>&nbsp;(
        <span class="unitPrice' . $index . ' glass">' . pricing($glass->getPrice()) . '</span> * 
            <span class="qty' . $index . '">' . $glass->getQty() . '</span>)</div>';
    
    echo '<div class="column">Matt price: $<span id="totalmatt' . $index . '"></span>&nbsp;
        (<span class="unitPrice' . $index . ' matt">' . pricing($matt->getPrice()) . '</span> * 
            <span class="qty' . $index . '">' . $matt->getQty() . '</span>)</div>';
    echo '<div class="ui divider"></div><div class="column"><strong>Set Price</strong>: $
        <span id="setPrice' . $index . '"></span></div>';
}

function space($num)
{
    $space = '';
    while($num-- > 0)
    {
        $space .= '&nbsp;';
    }
    return $space;
}

function pricing($num)
{
    return number_format((int)$num);
}
?>


<!DOCTYPE html>
<html lang=en>
	<?php include 'includes/head.php'; ?>
<body>
	<main>
	<?php
include 'includes/header.php';
?>
	<div class="ui center aligned huge header">
		<i class="shopping cart icon"></i>Shopping Cart
	</div>
	</br>
	<h4 class="ui horizontal divider horizheader">
		<i class="tag icon"></i> List of Items
	</h4>
	<div class="ui grid">
		<div class="one colunm centered row">
			<div class="fourteen wide column">
				<div class="ui black ribbon label">Paintings</div>
				<div class="ui attached segment">
					<form id="cartForm" class="ui form" method="post"
						action="addToCart.php">
									<?php output();?>
					    <div class="ui three inline fields">
							<div class="twelve wide field"></div>
							<div class="three wide field">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <!-- line up -->
								<select id="shippingMethod" name="shipping" class="ui search dropdown">
									<option value="selected" disabled selected
										style="display: none;"></option>
									<option value="Standard">Standard&nbsp;&nbsp;</option>
									<option value="Express">Express&nbsp;&nbsp;</option>
								</select>
							</div>
						</div>
						<div class="ui grid ">
							<div class="twelve wide column"></div>
							<div class="four wide column">
								<strong>Subtoal</strong>: &nbsp;$ <span id="subtotal"></span> </br>
								<strong>Shipping</strong>: &nbsp;$<span id="shipping"></span>
								<div class="ui divider"></div>
								<strong>Total Price</strong>: &nbsp;$<span id="total"></span> </br>
								</br>
								<button class="ui orange icon button">Proceed to Checkout</button>
							</div>
						</div>
						</br>
					</form>
				</div>
				<div class="ui grid">
					<div class="ui eight wide column"><?php generateEmptyButtons('addToCart', 'cart');?></div>
					<div class="ui eight wide column"><?php generateContinueShoppingButton(); ?></div>
				</div>
			</div>
		</div>
	</div>
	</br>
	</br>
	</br>
	</main>
	<footer class="ui black inverted segment">
		<div class="ui container">WEB II Assignment3</div>
	</footer>
</body>

</html>