<?php
require_once 'config.php';
include_once 'classes/GalleriesDataGateway.class.php';

function outputData()
{
    $galleries = new GalleriesDataGateway();
    displayGalleries($galleries->getAll());
    $galleries->disconnect();
}

function displayGalleries($res)
{
    foreach($res as $row)
    {
        echo '<div class="card"><div class = "ui center aligned content">
             <a class="linkInCard" href="single-gallery.php?id=' . $row['GalleryID'] . '">
                 <div class = "ui blue medium header">' . utf8_encode($row['GalleryName']) . '</div></a>
                <div class = "ui tiny header">' . $row['GalleryCity'] . ' ' . $row['GalleryCountry'] . '</div></div></div>';
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
					<h1 class="ui huge header">Galleries</h1>
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