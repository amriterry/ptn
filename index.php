<?php
	require("includes/conf.inc.php");
	require("includes/functions.inc.php");
?>

<!doctype html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta name="keywords" content="Plus Two Notes, Educational Website, Science, Management, HSEB, Notes, Questions, Refrence Books, Syllabus" />
<meta name="description" content="Plus Two Notes is representing class confabs online! We provide you with rich Notes and other educational materials which are benificial for your +2 level education. 'Experience your school at your Home'" />
<head>
	
	<title>Plus Two Notes - A site for complete Plus Two HSEB based Notes</title>
	
	<?php require("includes/links.inc.php"); ?>

</head>
<body>

<div id="fb-root"></div>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=287895998045780&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="main">

	<?php

		require("includes/header.inc.php"); 

		/*if(!isset($_SESSION['userLogin'])){
			require("includes/box-container.inc.php");
		}*/

	?>

	<div id="page">

		<div class="wrapper">

			<section id="left-col">
		
				<?php

					if(!isset($_SESSION['userLogin'])){
						require("includes/landingpage.inc.php");

						echo '<div id="featured-posts">
							<h4>Featured Posts</h4><br />';

						$fpArray = post::fp();
						if($fpArray == 'empty'){
							echo '<img src="'.$website.'assets/img/smile_face.png" /><br /><p style="color:#AAA;font-size:1.5em;">No Featured Posts to show</p>';
						} else {
							foreach($fpArray as $fp){

								echo '<div class="fp">
									<h5 class="fp-heading">'.truncate($fp['postTitle'],100).'</h5>
									<p><small>'.truncate(strip_tags($fp['postText']),200).'</small></p>
									<a href="'.generate_link($fp['postTitle'],$fp['postId']).'">View This Post</a>
								</div>';
							}
						}
					
						echo '
						</div>';

						echo '

						<div style="text-align:center;margin:2em 0;" id="ytplayer-container"></div>';
					} else {
						require("includes/post-reviews.inc.php");
					}

				?>

				
			</section>

			<?php
				require("includes/rightNav.inc.php"); 
			?>
			
		</div>
		
	</div>

	<div class="cleaner"></div>

	<?php require("includes/footer.inc.php"); ?>

</div>


</body>
</html>