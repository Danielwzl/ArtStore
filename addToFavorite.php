<?php
include_once ('classes/FavoriteItem.class.php');
if(!isset($_SESSION)) session_start();
$isAdd = '';
$action = isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : '';
if(!isset($_SESSION['favorite'])) $_SESSION['favorite'] = new FavoriteItem();
$like = &$_SESSION['favorite'];
switch($action)
{
    case 'add':
        if(isset($_GET['id'], $_GET['name']) && !empty($_GET['id']) && !empty($_GET['name']))
        {
            if($like->add($_GET['id'], $_GET['name'])) $isAdd = 'add';
            else $isAdd = 'false';
        }
        break;

    case 'remove':
        if(isset($_GET['key'], $_GET['name']) && $_GET['key'] >= 0 && !empty($_GET['name']))
            $like->remove($_GET['key'], $_GET['name']);
            break;

    case 'empty':
        if(isset($_GET['name']) && !empty($_GET['name']))
            $like->emptyList($_GET['name']);
            break;
    default:
        echo 'invalid action';
}

header('Location: ' . 'viewFavorite.php?isAdd=' . $isAdd);




