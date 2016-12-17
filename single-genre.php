<?php
require_once ('config.php');
include 'includes/display_painting.php';
include_once 'classes/SingleGenreDataGateway.class.php';

function outputData()
{
    $genre = new SingleGenreDataGateway();
    $id = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : '1';
    $row = $genre->getAllById($id);
    if(empty($row)) $row = $genre->getAllById('1');
    display($row, 'displayGenreInfo');
    $genre->disconnect();
}

function displayGenreInfo($row)
{
    $genreName = utf8_encode($row['GenreName']);
    echo '<section class="ui segment grey100">
        <div class="ui centered grid"><div class="two column row">';
    echo '<div class="two wide column">
        <div class="ui card">
        <a class="image" href="' . $row['Link'] . '">
            <img src="images/art/genres/square-medium/' . $row['GenreID'] . '.jpg" class="headerImage" alt="' . $genreName . '">
                </a>
                </div></div>';
    echo '<div class="eight wide column"><h1 class="ui header">' . $genreName . '</h1>';
    echo '<p>' . utf8_encode($row['des']) . '</p></div>';
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