<?php
	require("../includes/conf.inc.php");
	require("../includes/functions.inc.php");
	
	if(isset($_GET['q'])){
		if(!empty($_GET['q'])){
			$sq = sanitize_text($_GET['q']);

			$searchResult = post::searchPosts($sq,'');
			if($searchResult == false){
				die($e);
			}
		} else {
			header("location: ../search/");
		}
		
	} else {
		$sq = "Search";
		$searchResult = "undefined";
	}
?>

<!doctype html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,intial-scale=1" />
<head>
	
	<title><?php if(isset($_GET['q'])){ echo trim(htmlentities($_GET['q'])); } else { echo 'Search'; } ?> - Plus Two Notes Search</title>
	
	<?php require("../includes/links.inc.php"); ?>

</head>
<body>

<div id="main">

<?php require("../includes/header.inc.php"); ?>

<div id="page">

	<div class="wrapper">
	
		<section id="left-col">
		
				<h2 class="welcome-heading" style="text-align:left;">Search For: <span><?php if(!empty($_GET['q'])){echo trim(htmlentities($_GET['q']));} ?></span></h2>
				
				<!--<div id="search-filters">
					<h4>Filter the Search</h4>
					
					<form method="post">
						<div class="filter">
							Search For: <input type="text" autocomplete="off" name="sq" value="<?php //echo trim(htmlentities($sq)); ?>" />
						</div>
						<div class="filter">
							Class: <select><option>XI</option><option>XII</option></select>
						</div>
						<div class="filter">
							Faculty: <select><option>Science</option><option>Management</option></select>
						</div>
						<div class="filter">
							Subject: <select><option>Physics</option><option>Chemistry</option></select>
						</div>
						<div class="filter">
							Chapter: <select><option>1st chapter</option><option>2nd chapter</option></select>
						</div>
						<div class="filter">
							Post Type: <select><option>Note</option><option>Question</option></select>
						</div
						<center><input type="button" value="Filter Search" name="filter-search" class="anchor-btn">


						<span>Added at: '.$dateTime['mday'].' '.$dateTime['month'].', '.$dateTime['year'].'<br />


					</form>
					
				</div>
				
				<h4>Results:</h4><br />-->
				
				<div class="pl-container">
				<?php
				
				if($searchResult == 'empty'){
					echo '<h5>No Results Found! Try Another Key word</h5><br />';
					echo 'What\'s Your query?<br /><br />
					<form action="../search/" method="get">
					<input type="text" name="q" placeholder="Search For Posts" style="width:100%;" value="'.trim(htmlentities($_GET['q'])).'"/>
					<br /><br /><input type="submit" value="Search" /><br /><br />
					</form>';
				} else if($searchResult == 'undefined'){
					echo 'What\'s Your query?<br /><br />
					<form action="../search/" method="get">
					<input type="text" name="q" placeholder="Search For Posts" style="width:100%;"/>
					<br /><br /><input type="submit" value="Search" /><br /><br />
					</form>';
				} else {
					echo 'What\'s Your query?<br /><br />
					<form action="../search/" method="get">
					<input type="text" name="q" placeholder="Search For Posts" style="width:100%;" value="'.trim(htmlentities($_GET['q'])).'"/>
					<br /><br /><input type="submit" value="Search" /><br /><br />
					</form>';
					$numSr=sizeof($searchResult);
					if($numSr == 1){
						$suffix = '';
					} else {
						$suffix = 's';
					}
					echo '<h5>'.$numSr.' result'.$suffix.' found</h5><br />';

					foreach($searchResult as $sr){
						$dateArray = getdate(strtotime($sr['postDate']));
						echo '
							<a href="'.generate_link($sr['postTitle'],$sr['postId']).'" class="pl-anchor">
								<div class="pl">
									<div class="plDate">
										<span>'.$dateArray['mday'].'</span>
										<span>'.$dateArray['month'].'</span>
									</div>
									<div class="plDetail">
										<h5>'.$sr['postTitle']; 
										if($sr['imp'] == 1){ 
											echo '<span class="imp">Imp</span>'; 
										} echo '
										</h5>
										<span>Category: '.$sr['postTyp'].'</span><br />
										<span>'.$sr['class'].' | '.$sr['facultyName'].' | '.$sr['subjectName'].'</span>
									</div>
									<div class="cleaner"></div>
								</div>
							</a>';
					}
				}
					
				?>
					
				</div>
				
				<?php //if($num_el>10){ echo '<center><a href="#" class="load-more">Load More</a></center>'; } ?>
		</section><!--end of #left-col-->
		
		<?php require("../includes/rightNav.inc.php"); ?>
		
	</div><!--end of .wrapper-->
	
</div><!--end of #page -->

<div class="cleaner"></div>

<?php require("../includes/footer.inc.php"); ?>

</div>

</body>
</html>