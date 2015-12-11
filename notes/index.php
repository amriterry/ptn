<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

$postTypId = 1;

if(isset($_GET['subjectId'])){
	$subId = intval($_GET['subjectId']);
	$notes = post::all(1,$postTypId,$subId);

	if(!$notes){
		die($e);
	} else if($notes == 'empty'){
		$title = 'No Note posted';
		$titleBar = 'Notes';
		$content = '<center><img src="'.$website.'assets/img/smile_face.png" /><br /><p style="color:#AAA;font-size:1.5em;">No Notes to Show</p></center>';
	} else {
		$class = $notes[0]['class'];
		$facultyName = $notes[0]['facultyName'];
		$subjectName = $notes[0]['subjectName'];

		$title = "Grade $class | $facultyName | $subjectName Notes";
		$titleBar = $title;
		$content = '';

		foreach($notes as $note){
			$dateArray = getdate(strtotime($note['postDate']));
			$content .= '
			<a href="'.generate_link($note['postTitle'],$note['postId']).'" class="pl-anchor">
				<div class="pl">
					<div class="plDate">
						<span>'.$dateArray['mday'].'</span>
						<span>'.$dateArray['month'].'</span>
					</div>
					<div class="plDetail">
						<h5>'.$note['postTitle']; 
						if($note['imp'] == 1){ 
							$content .= '<span class="imp">Imp</span>'; 
						} 
						$content .= '
						</h5>
						<span>'.$note['class'].' | '.$note['facultyName'].' | '.$note['subjectName'].'</span>
					</div>
					<div class="cleaner"></div>
				</div>
			</a>';
		}
	}

} else {
	//$notes = getPostList($postTypId);

	$notes = post::all(1,$postTypId);

	if(!$notes){
		die($e);
	} else if($notes == 'empty'){
		$title = 'No Note posted';
		$titleBar = 'Notes';
		$content = '<center><img src="'.$website.'assets/img/smile_face.png" /><br /><p style="color:#AAA;font-size:1.5em;">No Notes to Show</p></center>';
	} else {
		$title = 'Notes';
		$titleBar = $title;
		$content = '';

		foreach($notes as $note){
			$dateArray = getdate(strtotime($note['postDate']));
			$content .= '
			<a href="'.generate_link($note['postTitle'],$note['postId']).'" class="pl-anchor">
				<div class="pl">
					<div class="plDate">
						<span>'.$dateArray['mday'].'</span>
						<span>'.$dateArray['month'].'</span>
					</div>
					<div class="plDetail">
						<h5>'.$note['postTitle']; 
						if($note['imp'] == 1){ 
							$content .= '<span class="imp">Imp</span>'; 
						} 
						$content .= '
						</h5>
						<span>'.$note['class'].' | '.$note['facultyName'].' | '.$note['subjectName'].'</span>
					</div>
					<div class="cleaner"></div>
				</div>
			</a>';
		}
	}
}

?>

<!doctype html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta name="keywords" content="Plus Two Notes, Educational Website, Science, Management, HSEB, Notes, Questions, Refrence Books, Syllabus, Notes List" />
<meta name="description" content="Plus Two Notes Notes List" />
<head>
	
	<title><?php if(isset($_GET['subjectId'])){	echo $title; } else { echo "Notes"; } ?> - Plus Two Notes</title>
	
	<?php require("../includes/links.inc.php"); ?>

</head>
<body>

<div id="main">

<!--header-->
<?php require("../includes/header.inc.php"); ?>

<div id="page">
	<div class="wrapper">
		<div id="left-col">
			<h2 class="welcome-heading">Notes</h2>

			<h6 class="divisionHeading">
				<?php 
					if(isset($_GET['subjectId']) && $notes != 'empty'){
						echo $title; 
					} else { 
						echo '';
					}
				?>
			</h6>

			<?php echo $content; ?>

		</div>
		
		<?php require("../includes/rightNav.inc.php"); ?>
	</div>
</div>

<?php require("../includes/footer.inc.php"); ?>

</div>

</body>
</html>