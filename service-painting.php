<?php
include_once 'classes/PaintingsDataGateway.class.php';
include_once 'classes/FavoriteItem.class.php';

$list = array();
if(!isset($_SESSION)) session_start();
$rows = getRows();
$needSearchInFavoriteList = false;
if(isset($_SESSION['favorite']) && !empty($_SESSION['favorite']->getList('paintings')))
{
    $needSearchInFavoriteList = true;
    $paintingIDs = $_SESSION['favorite']->getList('paintings');
}
foreach($rows as $index => $row)
{
    $list[$index] = $row;
    //if favorite has paiting, js neec to know the button of which painting should be red, this signal need to be send to js as Json too
    if($needSearchInFavoriteList) $list[$index]['Heart'] = in_array($row['PaintingID'], $paintingIDs) ? 'red' : 'grey';
    foreach($row as $key => $val)
    {
        $list[$index][$key] = utf8_encode($val);
    }
}
header('Content-Type: application/json');
echo json_encode($list);

function getRows()
{
    $paintings = new PaintingsDataGateway();
    $paintings->setLimit(20);
    $rows = null;
    if(isset($_POST['search']) && !empty($_POST['search']))
        $rows = getFilteredData($paintings, 'Title', $_POST['search'] . '%');
    else if(isset($_POST['artist']) && !empty($_POST['artist']))
        $rows = getFilteredData($paintings, 'ArtistID', $_POST['artist']);
    else if(isset($_POST['museum']) && !empty($_POST['museum']))
        $rows = getFilteredData($paintings, 'GalleryID', $_POST['museum']);
    else if(isset($_POST['shape']) && !empty($_POST['shape']))
        $rows = getFilteredData($paintings, 'ShapeID', $_POST['shape']);
    else $rows = getDefaultData($paintings);
    $paintings->disconnect();
    return $rows;
}

function getFilteredData($paintings, $type, $queryString)
{
    $bindingVar = ':' . $type;
    $logicOperator = $type == 'Title' ? ' like ' : ' = '; //search uses LIKE clause, other use = operator
    $sql = $paintings->getSQL() . ' where ' . $type . $logicOperator . $bindingVar;
    return $paintings->getBySQL($sql, array($bindingVar => $queryString));
}

function getDefaultData($paintings)
{
    return $paintings->getAll();
}
?>