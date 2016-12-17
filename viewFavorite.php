<?php
include_once 'classes/FavoritePaintingDataGateway.class.php';
include_once 'classes/FavoriteArtistDataGateway.class.php';
include 'includes/buttons.php';

function outputArtist()
{
    $data = new FavoriteArtistDataGateway();
    outputList('artists', $data);
    $data->disconnect();
    $data = null;
}

function outputPainting()
{
    $data = new FavoritePaintingDataGateway();
    outputList('paintings', $data);
    $data->disconnect();
    $data = null;
}

function outputList($type, $obj)
{
    if(!isset($_SESSION['favorite']) || empty($_SESSION['favorite'])) $_SESSION['favorite'] = new FavoriteItem();
    $list = $_SESSION['favorite']->getList($type);
    
    foreach($list as $key => $id) //$key is the positon in array of painting and artist, easy to access them when removing 
    {
        displayList($type, $obj->getByID($id), $key);
    }
}

function displayList($type, $row, $Key)
{
    switch($type)
    {
        case 'paintings':
            echo '<tr><td><a href="single-painting.php?id=' . $row['PaintingID'] . '">
                <img src="images/art/works/square-small/' . $row['ImageFileName'] . '.jpg" alt="' . $row['Title'] . '"></a></td>';
            echo '<td>' . utf8_encode($row['Title']) . '</td>';
            echo '<td>' . generateRemoveButtons($Key, 'addToFavorite', 'paintings') . '</td></tr>';
            break;
        case 'artists':
            echo '<tr><td><a href="single-artist.php?id=' . $row['ArtistID'] . '">
                <img src="images/art/artists/square-thumb/' . $row['ArtistID'] . '.jpg" alt="' . $row['LastName'] . '"></a></td>';
            echo '<td>' . utf8_encode($row['FirstName'] . ' ' . $row['LastName']) . '</td>';
            echo '<td>' . generateRemoveButtons($Key, 'addToFavorite', 'artists') . '</td></tr>';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang=en>
	<?php include 'includes/head.php'; ?>
<body>
	<main>
	<?php
include 'includes/header.php';
?>

	<div class="ui center aligned huge header">
		<i class="heart icon"></i>Favorites
	</div>
	</br>
	<h4 class="ui horizontal divider header">
		<i class="tag icon"></i> List of Favorites
	</h4>
	<div class="ui grid">
		<div class="three colunm centered row">

			<div class="six wide column">
				<div class="ui black ribbon label">Paintings</div>
				<div class="ui attached segment">
					<table class="ui center aligned selectable fixed table">
						<thead>
							<tr>
								<th>Painting</th>
								<th>Painting Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php outputPainting(); ?>
					</tbody>
					</table>
				</div>
               <?php generateEmptyButtons('addToFavorite', 'paintings'); ?>
			</div>
			<div class="two wide column"></div>
			<div class="six wide column">
				<div class="ui black ribbon label">Artists</div>
				<div class="ui attached segment">
					<table class="ui center aligned selectable fixed table">
						<thead>
							<tr>
								<th>Artist</th>
								<th>Artist Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php outputArtist(); ?>
					</tbody>
					</table>
				</div>
			<?php generateEmptyButtons('addToFavorite', 'artists'); ?>
			</div>
		</div>
	</div>
	</br>
	</br>
	</br>
	</main>
	<footer class="ui black inverted segment">
		<div class="ui container">WEB II Assignment3</div>
	</footer>
</body>

</html>