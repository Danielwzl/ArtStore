<?php
require_once 'config.php';
include_once 'classes/ArtistsDataGateway.class.php';
include 'includes/buttons.php';
include 'includes/searchExisting.php';

function outputData()
{
    $artists = new ArtistsDataGateway();
    displayArtists($artists->getAll());
    $artists->disconnect();
}

function displayArtists($res)
{
    foreach($res as $row)
    {
        $lName = utf8_encode($row['LastName']);
        $fName = utf8_encode($row['FirstName']);
        $id = $row['ArtistID'];
        echo '<div class="card">';
        echo '<a class="image" href="single-artist.php?id=' . $id . '">
                        <img src="images/art/artists/square-medium/' . $id . '.jpg" alt=' . $lName . '>
                     </a>
                      <div class="center aligned content">
                        <a class="ui tiny header" href="single-artist.php?id=' . $id . '">' . $fName . ' ' . $lName . '</a></div>';
        if(isExistInFav($id, 'artists'))
            generateFavoriteButtons($id, ' bottom attached ', '', 'view favourite', 'artists', 'red');
        else generateFavoriteButtons($id, ' bottom attached ', '', 'add favourite', 'artists', '');
        echo '</div>';
    }
}

?>

<!DOCTYPE html>
<html lang=en>
<?php include 'includes/head.php'; ?>
    <body>
	<main>
        	<?php include 'includes/header.php'; ?>
        	<div class="banner1-container">
		<div class="ui centered grid">
			<div class="centered row">
				<div class="four wide column">
					<h1 class="ui huge header">Artists</h1>
				</div>
			</div>
		</div>
	</div>
	<br />
	<br />
	<div class="ui six centered cards">
     <?php outputData(); ?>
     </div>
	<br />
	<br />
	</main>
	<footer class="ui black inverted segment">
		<div class="ui container">WEB II Assignment3</div>
	</footer>

</body>
</html>