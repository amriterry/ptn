<?php
	require("../includes/conf.inc.php");
	require("../includes/functions.inc.php");

	$catTyp = array('notes','questions','syllabus','refrence','downloads');
	$catDisplayName = array('Notes','Questions','Syllabus','Refrence Books','Downloads');

	if(!isset($_GET['cat'])){
		header("location: ../");
	} else {
		$cat = sanitize_text($_GET['cat']);

		if(!in_array($cat, $catTyp)){
			header("location: ../");
		} else {
			$catPos = array_search($cat, $catTyp);
			$displayName = $catDisplayName[$catPos];

			if(isset($_GET['class'],$_GET['faculty'],$_GET['subject'])){
				$content = 'Specific notes of subject,faculty and its class';
			} else if(isset($_GET['class'],$_GET['faculty'])){
				$content = 'All notes of a class and faculty';
			} else if(isset($_GET['class'])){
				$content = 'All notes of a class';
			} else {
				$content = 'All notes';
			}
		}
	}
	
?>

<!doctype html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,intial-scale=1" />
<head>

	<link href="../assets/css/default.css" rel="stylesheet" />
	
	<title><?php echo $displayName; ?></title>
	
	<?php require("../includes/links.inc.php"); ?>

</head>
<body>
<!--header-->
<?php require("../includes/header.inc.php"); ?>

<div id="page">
	<div class="wrapper">
		<div id="left-col">
			<h2 class="welcome-heading"><?php echo $displayName; ?></h2>

			<?php echo $content; ?>
		</div>
		
		<?php require("../includes/rightNav.inc.php"); ?>
	</div>
</div>

<?php require("../includes/footer.inc.php"); ?>

</body>
</html>