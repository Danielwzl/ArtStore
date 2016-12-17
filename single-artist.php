<?php
require_once ('config.php');
include 'includes/display_painting.php';
include_once 'classes/SingleArtistDataGate.class.php';
include 'includes/buttons.php';
include 'includes/searchExisting.php';

function outputData()
{
    $artist = new SingleArtistDataGateway();
    $id = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : '1';
    $row = $artist->getAllById($id);
    if(empty($row)) $row = $artist->getAllById('1');
    display($row, 'displayArtistInfo');
    $artist->disconnect();
}

function displayArtistInfo($row)
{
    $gender = $row['Gender'] == 'M' ? 'Male' : 'Female';
    $id = $row['ArtistID'];
    echo '<section class="ui segment grey100">
        <div class="ui centered grid"><div class="two column row">';
    if(isExistInFav($id, 'artists')) generateFavoriteButtons($row['ArtistID'], '', '', '', 'artists', 'red');
    else generateFavoriteButtons($row['ArtistID'], '', '', '', 'artists', '');
    echo '<div class="two wide column"> 
                  <img src="images/art/artists/square-medium/' . $id . '.jpg" class="ui big image" id="artwork" alt="' . utf8_encode($row['LastName']) . '">
              <div class="ui fullscreen modal">
                 <div class="image content">
                      <img src="images/art/artists/medium/' . $id . '.jpg" alt="' . utf8_encode($row['LastName']) . '" class="ui big image" id="artwork">
                          <div class="description">
							      <p>' . utf8_encode($row['Details']) . '</p>
						   </div></div></div>';
    echo '</div><div class="eight wide column">
                <a href="' . $row['ArtistLink'] . '">
                     <h1 class="ui header">' . utf8_encode($row['FirstName']) . " " . utf8_encode($row['LastName']) . '</h1></a>';
    echo '<span>' . $row['Nationality'] . '</span></br>';
    echo '<span>' . $gender . '</br>( ' . $row['YearOfBirth'] . ' ~ ' . $row['YearOfDeath'] . ' )' . '</span>';
    echo '<div class="ui divider"></div>';
    echo '<p>' . utf8_encode($row['Details']) . '</p></div>';
    echo '</div></div></section></br></br>';
}

?>
<!DOCTYPE html>
<html lang=en>
<?php include 'includes/head.php'; ?>
    <body>
	<main>
		<?php include 'includes/header.php'; outputData();?>
	</main>
	<footer class="ui black inverted segment">
		<div class="ui container">WEB II Assignment3</div>
	</footer>
</body>
</html>