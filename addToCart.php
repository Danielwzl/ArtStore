<?php
include_once 'classes/OneSetItem.class.php';

if(!isset($_SESSION)) session_start();
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = array();
$cart = &$_SESSION['cart'];
$action = isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : ''; //action from browse-painting
if($action === '') $action = isset($_POST['action']) && !empty($_POST['action']) ? $_POST['action'] : ''; //action from submitting forms
$list = array();
$isAdd = ''; //for display message
switch($action)
{
    case 'add':
        $id = getQueryString('id');
        $qty = getQueryString('qty');
        if($qty == 0) $qty = 1; // error handling
        $list['getPainting'] = $id;
        $list['getFrame'] = getQueryString('Frame');
        $list['getGlass'] = getQueryString('Glass');
        $list['getMatt'] = getQueryString('Matt');
        addItemToCart($qty, $cart, $list, $isAdd);
        break;
    
    case 'remove':
        if(isset($_GET['key']) && $_GET['key'] >= 0)
        {
            $key = $_GET['key'];
            if($key >= 0) unset($_SESSION['cart'][$key]);
        }
        break;
    
    case 'empty':
        unset($_SESSION['cart']);
        break;
    case 'update':
    case 'updateToHome': //update and do to index
        if(isset($_POST['key']) && !empty($_POST['key']))
        {
            $keys = $_POST['key'];
            foreach($keys as $index=>$oneKey)
            {
                $list = array();
                $qty = $_POST['qty'][$index];
                // if they are not empty, do not even put into list
                //it must true from isset, because it is from update
                $tempFrame = explode('|', $_POST['Frame'][$index])[0];
                $tempGlass = explode('|', $_POST['Glass'][$index])[0];
                $tempMatt = explode('|', $_POST['Matt'][$index])[0];
                if(!empty($tempFrame)) $list['getFrame'] = $tempFrame;
                if(!empty($tempGlass)) $list['getGlass'] = $tempGlass;
                if(!empty($tempMatt)) $list['getMatt'] = $tempMatt;
                updateCart($qty, $cart, $oneKey, $list);
            }
        }       
        break;
    default:
        echo 'invalid action';
}

if($action == 'updateToHome') header('Location: ' . 'index.php');
else header('Location: ' . 'viewCart.php?isAdd=' . $isAdd);

function getQueryString($name)
{
    // check isset coz qty and paintingId use this
    $querystring = isset($_GET[$name]) && !empty($_GET[$name]) ? $_GET[$name] : 0; //add from browse-painting
    if($querystring === 0) $querystring = isset($_POST[$name]) && !empty($_POST[$name]) ? $_POST[$name] : 0; //add from forms in single-painting
    return explode('|', $querystring)[0]; //ary[id|price, id|price] only need id
}

function addItemToCart($qty, &$cart, $list, &$isAdd)
{
    $prevPage = getQueryString('from');
    $index = search($cart, $list['getPainting']);
    if($index != -1) // already exist
    {
        $isAdd = 'overlap';
        $target = $cart[$index];
        if($prevPage == 'single-painting')
        {
            $target->setNewQty($qty);
            foreach($list as $method => $id)
            {
                if($method == 'getPainting') continue;
                if($id >= 0) 
                {
                    $target->$method()->setId($id); // could replace none to existing one if user does not select frame ect.
                }
            }
        }
        else $target->addSetQty($qty); // the qty in frame glass matt that are none will be clear when update detail from dbs
    }
    else
    {
        $isAdd = 'add';
        addNew($qty, $cart, $list);
    }
}

function addNew($qty, &$cart, $list)
{
    $newPainting = $qty == 0 ? new PurchasedPainting($list['getPainting'], 1) : new PurchasedPainting($list['getPainting'], $qty);
    array_push($cart, new OneSetItem($newPainting, 
                                    new PurchasedFrame($list['getFrame'], $qty), 
                                    new PurchasedGlass($list['getGlass'], $qty), 
                                    new PurchasedMatt($list['getMatt'], $qty)));
}

function search($cart, $paintingId)
{
    foreach($cart as $key => $value)
    {
        $target = $value->isSameSet($paintingId);
        if($target != null) return $key;
    }
    return -1;
}

function updateCart($qty, &$cart, $key, $list)
{
    if($key >= 0)
    {
        $target = $cart[$key];
        $target->getPainting()->setQty($qty);
        foreach($list as $method => $id)
        {//if list is empty, means user didnt change anything from cart, loop will not run
            $item = $target->$method();
            if($id > 0) $item->setQty($qty);
            $item->setId($id); //also take -1, and object will update its name;none, qty 0, price 0
        }
    }
}
?>

