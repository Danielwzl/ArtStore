<?php
require_once ('config.php');
include 'includes/display_painting.php';
include_once 'classes/SingleGalleryDataGateway.class.php';

function getData()
{
    $gallery = new SingleGalleryDataGateway();
    $id = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : '3';
    $row = $gallery->getAllById($id);
    if(empty($row)) $row = $gallery->getAllById('3');
    display($row, 'displayGalleryInfo');
    $gallery->disconnect();
}

function displayGalleryInfo($row)
{
    echo '<section class="ui segment grey100">
        <div class="ui centered grid"><div class="two column row">';
    echo '<div class="four wide column">
                          </br><div class = "ui large header">' . utf8_encode($row['GalleryName']) . '</div>
                           <a href="' . $row['GalleryWebSite'] . '">' . utf8_encode($row['GalleryNativeName']) . '</a>
                            </br></br><p>' . $row['GalleryCity'] . ', ' . $row['GalleryCountry'] . '</p></div>';
    
    echo '<div class="eight wide column">';
    outputMap($row);
    echo '</div></div></section></br></br>';
}

function outputMap($row)
{
    echo '<div id="map" style="width: 120%; height: 500px"></div>
            <script>
              function initMap() {
                    var myLatLng = {lat: ' . $row['Latitude'] . ', lng: ' . $row['Longitude'] . '};
                    var map = new google.maps.Map(document.getElementById("map"), {
                      center: myLatLng,
                      scrollwheel: false,
                      zoom: 18
                    });
                          
                        var marker = new google.maps.Marker({
                        position: myLatLng,
                        map: map,
                        title: "' . utf8_encode($row['GalleryName']) . '"
                    });       
              }

    </script>';
}

?>
<!DOCTYPE html>
<html lang=en>
<?php include 'includes/head.php'; ?>
    <body>
	<main>
		<?php include 'includes/header.php'; getData();?>
	</main>
	<footer class="ui black inverted segment">
		<div class="ui container">WEB II Assignment3</div>
	</footer>
	<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtMgI6hJYk1v5mapcog0SsS05uQ1UP0d0&callback=initMap"
		type="text/javascript"></script>
</body>
</html>