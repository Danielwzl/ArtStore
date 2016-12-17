<?php
require_once 'config.php';
include_once 'classes/GenresDataGateway.class.php';

function outputData()
{
    $genres = new GenresDataGateway();
    displayGenres($genres->getAll());
    $genres->disconnect();
}

function displayGenres($res)
{
    foreach($res as $row)
    {
        echo '<div class="card">
                    <a class="image" href="single-genre.php?id=' . $row['GenreID'] . '">
                        <img src="images/art/genres/square-medium/' . $row['GenreID'] . '.jpg" alt=' . $row['GenreName'] . '>
                     </a>
                      <div class="center aligned content">
                        <a class="ui tiny header" href="single-genre.php?id=' . $row['GenreID'] . '">' . $row['GenreName'] . '</a>
                      </div></div>';
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
					<h1 class="ui huge header">Genres</h1>
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