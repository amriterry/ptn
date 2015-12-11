<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

$postTypId = 2;

if(isset($_GET['subjectId'])){
	$subId = intval($_GET['subjectId']);
	
	$questions = post::all(1,$postTypId,$subId);

	if(!$questions){
		die($e);
	} else if($questions == 'empty'){
		$title = 'No Question posted';
		$titleBar = 'Questions';
		$content = '<center><img src="'.$website.'assets/img/smile_face.png" /><br /><p style="color:#AAA;font-size:1.5em;">No Questions to Show</p></center>';
	} else {
		$class = $questions[0]['class'];
		$facultyName = $questions[0]['facultyName'];
		$subjectName = $questions[0]['subjectName'];

		$title = "Grade $class | $facultyName | $subjectName Questions";
		$titleBar = $title;
		$content = '';

		foreach($questions as $note){
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
	$questions = post::all(1,$postTypId);

	if(!$questions){
		die($e);
	} else if($questions == 'empty'){
		$title = 'No Question posted';
		$titleBar = 'Questions';
		$content = '<center><img src="'.$website.'assets/img/smile_face.png" /><br /><p style="color:#AAA;font-size:1.5em;">No Questions to Show</p></center>';
	} else {
		$title = 'Questions';
		$titleBar = $title;
		$content = '';

		foreach($questions as $note){
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
<meta name="keywords" content="Plus Two Notes, Educational Website, Science, Management, HSEB, Notes, Questions, Refrence Books, Syllabus, Questions List" />
<meta name="description" content="Plus Two Notes Notes Questions List" />
<head>
	
	<title><?php if(isset($_GET['subjectId'])){	echo $title; } else { echo "Questions"; } ?> - Plus Two Questions</title>
	
	<?php require("../includes/links.inc.php"); ?>

</head>
<body>

<div id="main">

<!--header-->
<?php require("../includes/header.inc.php"); ?>

<div id="page">
	<div class="wrapper">
		<div id="left-col">
			<h2 class="welcome-heading">Questions</h2>

			<h6 class="divisionHeading">
				<?php 
					if(isset($_GET['subjectId']) && $questions != 'empty'){
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