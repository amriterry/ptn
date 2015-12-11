<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

$refrence = 'empty';
$postTypId = 4;

if(isset($_GET['subjectId'])){

	$subId = intval($_GET['subjectId']);

	$refrence = post::all(1,$postTypId,$subId);	

	if(!$refrence){
		die($e);
	}else if($refrence!= 'empty'){

		$class = $refrence[0]['class'];
		$facultyName = $refrence[0]['facultyName'];
		$subjectName = $refrence[0]['subjectName'];

		$content = '';

		foreach($refrence as $ref){
			$dateArray = getdate(strtotime($ref['postDate']));
			$content .= '
			<a href="'.generate_link($ref['postTitle'],$ref['postId']).'" class="pl-anchor">
				<div class="pl">
					<div class="plDate">
						<span>'.$dateArray['mday'].'</span>
						<span>'.$dateArray['month'].'</span>
					</div>
					<div class="plDetail">
						<h5>'.$ref['postTitle']; 
						if($ref['imp'] == 1){ 
							$content .= '<span class="imp">Imp</span>'; 
						} 
						$content .= '
						</h5>
						<span>'.$ref['class'].' | '.$ref['facultyName'].' | '.$ref['subjectName'].'</span>
					</div>
					<div class="cleaner"></div>
				</div>
			</a>';
		}

		$title = 'Grade '.$class.' | '.$facultyName.' | '.$subjectName.' | Refrence Books';
		$titleBar = $title;

	} else {
		$title = 'Refrence Books not posted yet';
		$titleBar = "Refrence";
		$content = '<center><img src="'.$website.'assets/img/smile_face.png" /><br /><p style="color:#AAA;font-size:1.5em;">No Refrence Books to Show</p></center>';
	}

}

?>

<!doctype html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta name="keywords" content="Plus Two Notes, Educational Website, Science, Management, HSEB, Notes, Questions, Refrence Books, Syllabus, <?php if(isset($_GET['subjectId'])){ echo $title; } else { echo 'Refrence Books List'; } ?>" />
<meta name="description" content="Plus Two Notes Notes <?php if(isset($_GET['subjectId'])){ echo $title; } else { echo 'Refrence Books List'; } ?>" />
<head>
	
	<title><?php if(isset($_GET['subjectId'])){	echo $title; } else { echo "Refrence"; } ?> - Plus Two Notes</title>
	
	<?php require("../includes/links.inc.php"); ?>

</head>
<body>

<div id="main">

<?php

require("../includes/header.inc.php"); ?>

<div id="page">
	<div class="wrapper">
		<div id="left-col">
			<h2 class="welcome-heading">Refrence Books</h2>

			<h6 class="divisionHeading">
				<?php 
					if(isset($_GET['subjectId'])){
						if($refrence != 'empty'){
							echo $title;
						} 
					} else{ 
						echo 'List of Refrence Books';
					}
				?>
			</h6>
			<br />
			<?php
				if(!isset($_GET['subjectId'])){
					echo '<ul class="subList">
							<li><a href="#">Grade 11</a>
								<ul>
									<li><a href="#">Science</a>
										<ul>
											<li><a href="'.$website.'refrence/physics/1">Physics</a></li>
											<li><a href="'.$website.'refrence/chemistry/2">Chemistry</a></li>
											<li><a href="'.$website.'refrence/biology/3">Biology</a></li>
											<li><a href="'.$website.'refrence/maths/4">Maths</a></li>
											<li><a href="'.$website.'refrence/computer-science/6">Computer Science</a></li>
											<li><a href="'.$website.'refrence/english/5">English</a></li>
										</ul>
									</li>
									<li><a href="#">Management</a>
										<ul>
											<li><a href="'.$website.'refrence/business-maths/12">Business Maths</a></li>
											<li><a href="'.$website.'refrence/economics/13">Economics</a></li>
											<li><a href="'.$website.'refrence/accountancy/14">Accountancy</a></li>
											<li><a href="'.$website.'refrence/computer-science/15">Computer Science</a></li>
											<li><a href="'.$website.'refrence/english/16">English</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Grade 12</a>
								<ul>
									<li><a href="#">Science</a>
										<ul>
											<li><a href="'.$website.'refrence/physics/7">Physics</a></li>
											<li><a href="'.$website.'refrence/chemistry/8">Chemistry</a></li>
											<li><a href="'.$website.'refrence/biology/9">Biology</a></li>
											<li><a href="'.$website.'refrence/maths/10">Maths</a></li>
											<li><a href="'.$website.'refrence/english/11">English</a></li>
										</ul>
									</li>
									<li><a href="#">Management</a>
										<ul>
											<li><a href="'.$website.'refrence/business-maths/17">Business Maths</a></li>
											<li><a href="'.$website.'refrence/economics/18">Economics</a></li>
											<li><a href="'.$website.'refrence/computer-science/19">Computer Science</a></li>
											<li><a href="'.$website.'refrence/english/20">English</a></li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>';
				} else {

					echo $content;
				}
			?>
			

		</div>
		
		<?php require("../includes/rightNav.inc.php"); ?>
	</div>
</div>

<?php require("../includes/footer.inc.php"); ?>

</div>

</body>
</html>