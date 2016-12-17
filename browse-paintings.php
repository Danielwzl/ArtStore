<?php
require_once ('config.php');
include_once 'classes/PaintingsDataGateway.class.php';
include 'includes/buttons.php';
include 'includes/searchExisting.php';

function outputData()
{
    $paintings = new PaintingsDataGateway();
    printDefalutHeader();
    $paintings->setLimit(20);
    $rows = $paintings->getAll(); // if it is not filtered, then generate another statement
    output($rows);
    $paintings->disconnect();
}

function output($rows)
{
    $i = 0;
    foreach($rows as $row)
    {
        outputPainting($row, $i++);
    }
}

function printDefalutHeader()
{
    echo '<div class="six wide column"><div class="ui small header top20Painting">ALL PAINTINGS [TOP20]</div></div>';
}

function outputPainting($row, $i)
{
    $id = $row['PaintingID'];
    echo '<div id="row' . $i . '" class="ui two column row">';
    echo '<div class="three wide right floated column">
        <a href="single-painting.php?id=' . $id . '"><img class="thumbnail" src="images/art/works/square-medium/';
    echo $row['ImageFileName'] . '.jpg" alt="' . $row['Title'] . '"></a></div>';
    echo '<div class="eleven wide column"><div class="ui large header title">' . utf8_encode($row['Title']) . '</div>';
    echo '<span class="lastName">' . utf8_encode($row['LastName']) . '</span>';
    echo '<br/><br/><p>' . utf8_encode($row['Excerpt']) . '</p>';
    echo '<span class="price">$' . number_format((int)explode('.', $row['MSRP'])[0]) . '</span><br/><br/>';
    if(isExistInFav($id, 'paintings'))
        generateButtons($id, '', '', '', '', 'paintings', 'red');
    else generateButtons($id, '', '', '', '', 'paintings', '');
    echo '<br/></div><div class="fourteen wide right floated column"><div class="ui divider"></div></div></div>';
}

?>

<!DOCTYPE html>
<html lang=en>
	<?php include 'includes/head.php'; ?>
<body>
	<main>
	<?php include 'includes/header.php';?>
	<div class="ui padded grid">
		<div class="column">
			<div class="ui segment">
				<div class="ui grid">
					<div class="ui two column row">
						<div class="four wide column"><?php include 'includes/side_nav.php';?></div>
						<div class="twelve wide column">
							<div class="ui huge header">Paintings</div>
							<br />
							<div id="defalut20" class="ui grid"><?php outputData();?></div>
							<div id="loader">
								<div class="ui active inverted dimmer">
									<div class="ui large inline text loader">Loading</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</main>
	<footer class="ui black inverted segment">
		<div class="ui container">WEB II Assignment3</div>
	</footer>
</body>

</html>