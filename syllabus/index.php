<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

$syllabus = 'empty';
$postTypId = 3;

if(isset($_GET['subjectId'])){

	$subId = intval($_GET['subjectId']);

	$syllabus = post::all(1,$postTypId,$subId);

	if(!$syllabus){
		die($e);
	}else if($syllabus != 'empty'){

		$class = $syllabus[0]['class'];
		$facultyName = $syllabus[0]['facultyName'];
		$subjectName = $syllabus[0]['subjectName'];

		$content = '';

		foreach($syllabus as $syll){
			$dateArray = getdate(strtotime($syll['postDate']));
			$content .= '
			<a href="'.generate_link($syll['postTitle'],$syll['postId']).'" class="pl-anchor">
				<div class="pl">
					<div class="plDate">
						<span>'.$dateArray['mday'].'</span>
						<span>'.$dateArray['month'].'</span>
					</div>
					<div class="plDetail">
						<h5>'.$syll['postTitle']; 
						if($syll['imp'] == 1){ 
							$content .= '<span class="imp">Imp</span>'; 
						} 
						$content .= '
						</h5>
						<span>'.$syll['class'].' | '.$syll['facultyName'].' | '.$syll['subjectName'].'</span>
					</div>
					<div class="cleaner"></div>
				</div>
			</a>';
		}

		$title = 'Grade '.$class.' | '.$facultyName.' | '.$subjectName.' | Refrence Books';
		$titleBar = $title;

	} else {
		$title = 'Syllabus not posted yet';
		$titleBar = "Syllabus";
		$content = '<center><img src="'.$website.'assets/img/smile_face.png" /><br /><p style="color:#AAA;font-size:1.5em;">No Syllabus to Show</p></center>';
	}
}

?>

<!doctype html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta name="keywords" content="Plus Two Notes, Educational Website, Science, Management, HSEB, Notes, Questions, Refrence Books, Syllabus, <?php if(isset($_GET['subjectId'])){ echo $title; } else { echo 'Syllabus List'; } ?>" />
<meta name="description" content="Plus Two Notes Notes <?php if(isset($_GET['subjectId'])){ echo $title; } else { echo 'Syllabus List'; } ?>" />
<head>
	
	<title><?php if(isset($_GET['subjectId'])){	echo $title; } else { echo "Syllabus"; } ?> - Plus Two Notes</title>
	
	<?php require("../includes/links.inc.php"); ?>

</head>
<body>
<!--header-->

<div id="main">

<?php

require("../includes/header.inc.php"); 

?>

<div id="page">
	<div class="wrapper">
		<div id="left-col">
			<h2 class="welcome-heading">Syllabus</h2>

			<h6 class="divisionHeading">
				<?php 
					if(isset($_GET['subjectId'])){
						if($syllabus != 'empty'){
							echo $title; 
						}
					} else { 
						echo 'List of Syllabus';
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
											<li><a href="'.$website.'syllabus/physics/1">Physics</a></li>
											<li><a href="'.$website.'syllabus/chemistry/2">Chemistry</a></li>
											<li><a href="'.$website.'syllabus/biology/3">Biology</a></li>
											<li><a href="'.$website.'syllabus/maths/4">Maths</a></li>
											<li><a href="'.$website.'syllabus/computer-science/6">Computer Science</a></li>
											<li><a href="'.$website.'syllabus/english/5">English</a></li>
										</ul>
									</li>
									<li><a href="#">Management</a>
										<ul>
											<li><a href="'.$website.'syllabus/business-maths/12">Business Maths</a></li>
											<li><a href="'.$website.'syllabus/economics/13">Economics</a></li>
											<li><a href="'.$website.'syllabus/accountancy/14">Accountancy</a></li>
											<li><a href="'.$website.'syllabus/computer-science/15">Computer Science</a></li>
											<li><a href="'.$website.'syllabus/english/16">English</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Grade 12</a>
								<ul>
									<li><a href="#">Science</a>
										<ul>
											<li><a href="'.$website.'syllabus/physics/7">Physics</a></li>
											<li><a href="'.$website.'syllabus/chemistry/8">Chemistry</a></li>
											<li><a href="'.$website.'syllabus/biology/9">Biology</a></li>
											<li><a href="'.$website.'syllabus/maths/10">Maths</a></li>
											<li><a href="'.$website.'syllabus/english/11">English</a></li>
										</ul>
									</li>
									<li><a href="#">Management</a>
										<ul>
											<li><a href="'.$website.'syllabus/business-maths/17">Business Maths</a></li>
											<li><a href="'.$website.'syllabus/economics/18">Economics</a></li>
											<li><a href="'.$website.'syllabus/computer-science/19">Computer Science</a></li>
											<li><a href="'.$website.'syllabus/english/20">English</a></li>
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