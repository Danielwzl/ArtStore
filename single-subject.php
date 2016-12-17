<?php
require_once ('config.php');
include 'includes/display_painting.php';
include_once 'classes/SingleSubjectDataGateway.class.php';

function outputData()
{
    $subject = new SingleSubjectDataGateway();
    $id = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : '1';
    $row = $subject->getAllById($id);
    if(empty($row)) $row = $subject->getAllById('1');
    display($row, 'displaySubjectInfo');
    $subject->disconnect();
}

function displaySubjectInfo($row)
{
    echo '<section class="ui segment grey100"><div class="ui grid">';
    echo '<div class="center aligned column"><h1 class="ui header">' . $row['SubjectName'] . '</h1>';
    echo '<img src="images/art/subjects/square-medium/' .  $row['SubjectID'] . '.jpg">';
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