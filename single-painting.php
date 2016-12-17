<?php
require_once ('config.php');
include_once 'classes/ReviewDataGateway.class.php';
include_once 'classes/SinglePaintDataGateway.class.php';
include_once 'classes/DisplaySubjectAsListGateway.class.php';
include_once 'classes/DropdownDataGateway.class.php';
include 'includes/buttons.php';
include 'includes/dropDown.php';
include 'includes/searchExisting.php';
include 'includes/displayExistingCartItem.php';

$painting = new SinglePaintDataGateway();
$review = new ReviewDataGateway();
$subject = new DisplaySubjectAsListGateway();
$frame = new DropdownDataGateway('Title, FrameID', 'TypesFrames');
$glass = new DropdownDataGateway('Title, GlassID', 'TypesGlass');
$matt = new DropdownDataGateway('Title, MattID', 'TypesMatt');
$frame->setOrderBy(' order by Title ');
$glass->setOrderBy(' order by Title ');
$matt->setOrderBy(' order by Title ');

$id = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : '5';

$rowOfMainInfo = $painting->getAllByID($id);
$rowOfReviews = $review->getAllByID($id);
$rowOfSubjects = $subject->getAllByID($id);

if(empty($rowOfMainInfo)) $rowOfMainInfo = $painting->getAllByID('5');
if(empty($rowOfReviews)) $rowOfReviews = $review->getAllByID('5');
if(empty($rowOfSubjects)) $rowOfSubjects = $subject->getAllByID('5');

$frames = $frame->getAll();
$glasses = $glass->getAll();
$matts = $matt->getAll();
$avgRating = calculateStars($rowOfReviews);

$frame->disconnect();
$glass->disconnect();
$matt->disconnect();
$painting->disconnect();
$review->disconnect();

function getData($obj, $id)
{
    return $obj->getAllByID($id);
}

function outputMImage($row)
{
    echo '<img src="images/art/works/medium/' . $row[0]['ImageFileName'] . '.jpg"' . 'alt="' . $row[0]['Title'] . '" class="ui big image" id="artwork">';
}

function outputLImage($row)
{
    echo '<img src="images/art/works/large/' . $row[0]['ImageFileName'] . '.jpg"' . 'alt="' . $row[0]['Title'] . '" class="ui image" id="artwork">';
}

function outputSingleData($row, $str)
{
    if($str == 'MSRP')
        echo '$' . number_format((int)explode('.', $row[0][$str])[0]);
    else echo utf8_encode($row[0][$str]);
}

function outputLinks($row, $str, $id, $php)
{
    foreach($row as $token)
    {
        echo '<li class="item"><a href="' . $php . '.php?id=' . $token[$id] . '">' . utf8_encode($token[$str]) . '</a></li>';
    }
}

function outputReview($row)
{
    $end = count($row) - 1;
    if($end == -1) return; // no comment
    foreach($row as $token)
    {
        echo '<div class="event"><div class="content"><div class="date">';
        echo explode(" ", $token['ReviewDate'])[0];
        echo '</div><div class="meta"><a class="like"> ';
        outputStars($token['Rating']);
        echo '</a></div><div class="summary">' . $token['Comment'];
        if($end > 0) echo '</div></div></div><div class="ui divider"></div>';
        $end--;
    }
}

function outputStars($numOfStar)
{
    $greyStars = 0;
    for($i = 0; $i < $numOfStar; $greyStars++, $i++)
    {
        echo '<i class="red star icon"></i>';
    }
    while($greyStars++ < 5)
    {
        echo '<i class="empty star icon"></i>';
    }
}

function calculateStars($row)
{
    $totalStars = 0;
    $numOfReview = count($row);
    if($numOfReview == 0) return 0;
    foreach($row as $token)
    {
        $totalStars += $token['Rating'];
    }
    return ceil($totalStars / $numOfReview);
}

?>

<!DOCTYPE html>
<html>
	<?php include 'includes/head.php';?>
	
	<body>
		<?php
include 'includes/header.php';
?>
	
	<main> <!-- Main section about painting -->
	<section class="ui segment grey100">
		<div class="ui doubling stackable grid container">

			<div class="nine wide column">
				<?php outputMImage($rowOfMainInfo);?>
				<div class="ui fullscreen modal">
					<div class="image content">
						<?php outputLImage($rowOfMainInfo);?>
						<div class="description">
							<p></p>
						</div>
					</div>
				</div>

			</div>
			<!-- END LEFT Picture Column -->

			<div class="seven wide column">

				<!-- Main Info -->
				<div class="item">
					<h2 class="header"><?php outputSingleData($rowOfMainInfo, 'Title'); ?></h2>
					<h3><?php outputSingleData($rowOfMainInfo, 'LastName'); ?></h3>
					<div class="meta">
						<p>
							<?php outputStars($avgRating); ?>
						</p>
						<p>
							<?php outputSingleData($rowOfMainInfo, 'Excerpt');?>
						</p>
					</div>
				</div>

				<!-- Tabs For Details, Museum, Genre, Subjects -->
				<div class="ui top attached tabular menu ">
					<a class="active item" data-tab="details"><i class="image icon"></i>Details</a>
					<a class="item" data-tab="museum"><i class="university icon"></i>Museum</a>
					<a class="item" data-tab="genres"><i class="theme icon"></i>Genres</a>
					<a class="item" data-tab="subjects"><i class="cube icon"></i>Subjects</a>
				</div>

				<div class="ui bottom attached active tab segment"
					data-tab="details">
					<table class="ui definition very basic collapsing celled table">
						<tbody>
							<tr>

								<td>Artist</td>
								<td><a
									href="single-artist.php?id=<?php outputSingleData($rowOfMainInfo, 'ArtistID');?>">
								<?php outputSingleData($rowOfMainInfo, 'LastName') ?></a></td>

							</tr>
							<tr>
								<td>Year</td>
								<td><?php outputSingleData($rowOfMainInfo, 'YearOfWork');?></td>
							</tr>
							<tr>
								<td>Medium</td>
								<td><?php outputSingleData($rowOfMainInfo, 'Medium');?></td>
							</tr>
							<tr>
								<td>Dimensions</td>
								<td><?php outputSingleData($rowOfMainInfo, 'Width');?> x <?php outputSingleData($rowOfMainInfo, 'Height');?></td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="ui bottom attached tab segment" data-tab="museum">
					<table class="ui definition very basic collapsing celled table">
						<tbody>
							<tr>
								<td>Museum</td>
								<td><a
									href="single-gallery.php?id=<?php outputSingleData($rowOfMainInfo, 'GalleryID')?>">
									<?php outputSingleData($rowOfMainInfo, 'GalleryName')?></a></td>
							</tr>
							<tr>
								<td>Assession #</td>
								<td><?php outputSingleData($rowOfMainInfo, 'AccessionNumber');?></td>
							</tr>
							<tr>
								<td>Copyright</td>
								<td><?php outputSingleData($rowOfMainInfo, 'CopyrightText');?></td>
							</tr>
							<tr>
								<td>URL</td>
								<td><a
									href="<?php outputSingleData($rowOfMainInfo, 'MuseumLink');?>">View
										painting at museum site</a></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="ui bottom attached tab segment" data-tab="genres">
					<ul class="ui list">
						<?php outputLinks($rowOfMainInfo, 'GenreName', 'GenreID', 'single-genre');?>
					</ul>

				</div>
				<div class="ui bottom attached tab segment" data-tab="subjects">
					<ul class="ui list">
						<?php outputLinks($rowOfSubjects, 'SubjectName', 'SubjectID', 'single-subject')?>
					</ul>
				</div>

				<!-- Cart and Price -->
				<div class="ui segment">
					<form id="itemForm" class="ui form" method="post"
						action="addToCart.php">
						<div class="ui tiny statistic">
							<div class="value"><?php outputSingleData($rowOfMainInfo, 'MSRP')?></div>
						</div>
						<div class="four fields">
							<div class="three wide field">
						<?php
    $item = isExistInCart($id, 'cart');
    if($item != null)
        echo '<label>Quantity</label> <input type="number" name="qty" min=1 value=' . $item->getSetQty() . '>';
    else echo '<label>Quantity</label> <input type="number" name="qty" min=1 value=1>';
    ?>
							</div>
							<div class="four wide field">
								<label>Frame</label> <select id="frame" name="Frame"
									class="ui search dropdown">
						<?php
    if($item != null)
    {
        $frame = $item->getFrame();
        displayTopOption(selectedItem($frame), $frame->getId()); // means need place id in this option
    }
    echo '<option value="0">None</option>';
    outputDropdownList($frames, 'FrameID');
    ?>
								</select>
							</div>
							<div class="four wide field">
								<label>Glass</label> <select id="glass" name="Glass"
									class="ui search dropdown">
						<?php
    if($item != null)
    {
        $glass = $item->getGlass();
        displayTopOption(selectedItem($glass), $glass->getId());
    }
    echo '<option value="0">None</option>';
    outputDropdownList($glasses, 'GlassID');
    ?>
								</select>
							</div>
							<div class="four wide field">
								<label>Matt</label> <select id="matt" name="Matt"
									class="ui search dropdown">
						<?php
    if($item != null)
    {
        $matt = $item->getMatt();
        displayTopOption(selectedItem($matt), $matt->getId());
    }
    echo '<option value="0">None</option>';
    outputDropdownList($matts, 'MattID');
    ?>
							</select> <input type="hidden" name="from"
									value="<?php echo basename(__FILE__, '.php')?>"> <input
									type="hidden" name="action" value="add">
							</div>
						</div>
					</form>
					<div class="ui divider"></div>
					<?php
    if($item != null)
        generateCartButtons($id, 'labeled', 'Replace in Cart', false, 'itemForm');
    else generateCartButtons($id, 'labeled', 'Add to Cart', false, 'itemForm');
    if(isExistInFav($id, 'paintings'))
        generateFavoriteButtons($id, 'labeled', 'right', 'View Favorites', 'paintings', 'red');
    else generateFavoriteButtons($id, 'labeled', 'right', 'Add to Favorites', 'paintings', '');
    ?>
				</div>
				<!-- END Cart -->

			</div>
			<!-- END RIGHT data Column -->
		</div>
		<!-- END Grid -->
	</section>
	<!-- END Main Section --> <!-- Tabs for Description, On the Web, Reviews -->
	<section class="ui doubling stackable grid container">
		<div class="sixteen wide column">

			<div class="ui top attached tabular menu ">
				<a class="active item" data-tab="first">Description</a> <a
					class="item" data-tab="second">On the Web</a> <a class="item"
					data-tab="third">Reviews</a>
			</div>

			<div class="ui bottom attached active tab segment" data-tab="first">
				<?php outputSingleData($rowOfMainInfo, 'Description');?>
			</div>
			<!-- END DescriptionTab -->

			<div class="ui bottom attached tab segment" data-tab="second">
				<table class="ui definition very basic collapsing celled table">
					<tbody>
						<tr>
							<td>Wikipedia Link</td>
							<td><a
								href="<?php outputSingleData($rowOfMainInfo, 'WikiLink');?>">View
									painting on Wikipedia</a></td>
						</tr>

						<tr>
							<td>Google Link</td>
							<td><a
								href="<?php outputSingleData($rowOfMainInfo, 'GoogleLink');?>">View
									painting on Google Art Project</a></td>
						</tr>

						<tr>
							<td>Google Text</td>
							<td><?php outputSingleData($rowOfMainInfo, 'GoogleDescription');?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- END On the Web Tab -->

			<div class="ui bottom attached tab segment" data-tab="third">
				<div class="ui feed">
						<?php outputReview($rowOfReviews); ?>
				</div>
			</div>
			<!-- END Reviews Tab -->

		</div>
	</section>
	<!-- END Description, On the Web, Reviews Tabs --> <!-- Related Images ... will implement this in assignment 2 -->
	<section class="ui container">
		<h3 class="ui dividing header">Related Works</h3>
		<div class="ui  stackable equal width grid "></div>
	</section>

	</main>

	<footer class="ui black inverted segment">
		<div class="ui container">WEB II Assignment3</div>
	</footer>

</body>
</html>