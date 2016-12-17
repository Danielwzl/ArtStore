<?php
require_once 'config.php';
include_once 'classes/SubjectsDataGateway.class.php';

function outputData()
{
    $subjects = new SubjectsDataGateway();
    displaySubjects($subjects->getAll());
    $subjects->disconnect();
}

function displaySubjects($res)
{
    foreach($res as $row)
    {
        $id =  $row['SubjectID'];
        $name = $row['SubjectName'];
        echo '<div class="card">
                    <a class="image" href="single-subject.php?id=' . $id . '">
                        <img src="images/art/subjects/square-medium/' . $id. '.jpg" alt=' . $name . '>
                     </a>
                      <div class="center aligned content">
                        <a class="ui tiny header" href="single-genre.php?id=' . $id . '">' . $name . '</a>
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
					<h1 class="ui huge header">Subjects</h1>
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