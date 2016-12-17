
<?php
require_once 'config.php';
include_once 'classes/DropdownDataGateway.class.php';

function outputMenu()
{
    $artists = new DropdownDataGateway('LastName, FirstName, ArtistID', 'Artists');
    $artists->setOrderBy(' order by LastName');
    $museums = new DropdownDataGateway('GalleryName, GalleryID', 'Galleries');
    $museums->setOrderBy(' order by GalleryName');
    $shapes = new DropdownDataGateway('ShapeName, ShapeID', 'Shapes');
    $shapes->setOrderBy(' order by ShapeName');
    $artistList = $artists->getAll();
    $museumList = $museums->getAll();
    $shapeList = $shapes->getAll();
    generateFilterMenu($artistList, 'Artist', 'ArtistID', 'LastName');
    generateFilterMenu($museumList, 'Museum', 'GalleryID', 'GalleryName');
    generateFilterMenu($shapeList, 'Shape', 'ShapeID', 'ShapeName');
    $artists->disconnect();
    $museums->disconnect();
    $shapes->disconnect();
}

function generateFilterMenu($list, $listName, $id, $str)
{
    echo '<div class="column">';
    echo '<div class="ui medium header">' . $listName . '</div>';
    echo '<select id="filter' . strtolower($listName) . '" name="' . strtolower($listName) . '">';
    echo '<option value="0">Select ' . $listName . '</option>';
    dropDown($list, $id, $str);
    echo '</select></div>';
}

function dropDown($list, $id, $str)
{
    foreach($list as $row)
    {
        if($id == 'ArtistID') // artist list need full name as queryString
            $fullName = utf8_encode($row['FirstName']) . ' ' . utf8_encode($row['LastName']);
        else $fullName = utf8_encode($row[$str]);
        echo '<option value="' . $row[$id] . '">' . $fullName . '</option>';
    }
}
?>

<div class="ui large header">Filters</div>
<div class="ui divider"></div>
<form id="filterForm" class="ui form" method="post" action="service-painting.php">
	<div class="ui one column grid">
			<?php outputMenu(); ?>
	</div>
</form>
