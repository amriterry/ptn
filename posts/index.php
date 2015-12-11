<?php
	require("../includes/conf.inc.php");
	require("../includes/functions.inc.php");
	
	$postId = intval($_GET['id']);

	$post = post::view($postId,1);
	if($post == false){
		die($e);
	}

	$comments = comment::getComments($postId);
	if($comments == false){
		die($e);
	}

	if($comments != 'empty'){
		$seeOlder = comment::checkOldComments($postId);
		if($seeOlder == false){
			$seeOlder = '';
		}
	}

	/*$likeObj = new like();
	$likeResult = $likeObj->getLikes($postId);
	if($likeResult == false){
		die($e);
	}

	if(isset($_SESSION['userLogin'])){
		$checkLike = $likeObj->checkLike($postId,$_SESSION['userId']);
		if($checkLike == false){
			die($e);
		} else if($checkLike == "liked"){
			$likeStatus = 'Unlike';
		} else if($checkLike == "unliked"){
			$likeStatus = 'Like';
		}
	}*/	
?>

<!doctype html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta name="keywords" content="Plus Two Notes, Educational Website, Science, Management, HSEB, Notes, Questions, Refrence Books, Syllabus, <?php echo $post['postTitle'].', '.$post['class'].', '.$post['subjectName'].', '.$post['chapterName']; ?>" />
<meta name="description" content="Plus Two Notes Notes <?php echo $post['postTitle'].' '.$post['class'].' '.$post['subjectName'].' '.$post['chapterName']; ?>" />
<head>
	
	<title><?php echo $post['postTitle']; ?> - Plus Two Notes</title>
	
	<?php require("../includes/links.inc.php"); ?>

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

<?php require("../includes/header.inc.php"); ?>

<div id="page">

	<div class="wrapper">
	
		<section id="left-col">
		
				<h1 class="welcome-heading" style="text-align:left;"><?php echo $post['postTitle']; ?></h1>
				
				<?php
				$dateArray = getdate(strtotime($post['postDate']));
				echo '
				<div class="post-detail">
					<div>
						Grade: <span>'. $post['class'].'</span><br />
						Faculty: <span>'.$post['facultyName'].'</span><br />
						Subject: <span>'.$post['subjectName'].'</span><br />
						Category: <span>'.$post['postTyp'].'</span><br />
						Post added at: <span>'.$dateArray['mday'].'<sup>th</sup> of '.$dateArray['month'].' '.$dateArray['year'].'</span><br />';
						if($post['imp'] == 1){
							echo '<b class="imp">Imp</b>';
						}
						if($post['fileName'] != NULL){
							echo 'Attached File: &nbsp;&nbsp;<a class="anchor-btn" href="'.$website.$post['fileUrl'].'">Download</a>';
						}
						
				echo '		
					</div>
				</div>';
				
				/*echo '<div id="like-container">';
				if(isset($_SESSION['userLogin'])){
					echo '<a href="javascript:void(0)" id="like" data-postId="'.$post['postId'].'">'.$likeStatus.'</a> . <span class="likedUsers"><span class="likeUserActivity"></span>';
						$i = 1;
						foreach($likeResult as $likedUser){
							echo '<a href="'.$website.'account/profile/'.$likedUser['username'].'">'.$likedUser['firstName'].'</a>';
							if($i == 2){
								break;
							}
						}
						echo ' like this.</span>';
				}
						
				echo '<div class="fb-like" id="fb" data-href="http://www.plustwelve.fh2web.com/posts/showpost/" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div></div>';
				*/
				?>
				<br />
				Share This Post On:

				<div id="social-share-container">

					<div style="position:relative;top:-3px;" class="fb-share-button" data-href="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-type="box_count"></div>
			
					<div class="g-plusone" data-size="tall"></div>

					<!-- Place this tag after the last +1 button tag. -->
					<script type="text/javascript">
					  (function() {
					    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					    po.src = 'https://apis.google.com/js/platform.js';
					    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
					  })();
					</script>
				</div>

				
				<div class="post">
				
				<?php echo $post['postText']; ?>
				
				</div>

				<?php

					$relp = post::relp($post['subjectId'],$post['postId']);

					if($relp != 'empty'){
						echo '<div id="relp">
						<h6>Related posts</h6>
						<p>';
						foreach($relp as $rel){
							echo '<a href="'.generate_link($rel['postTitle'],$rel['postId']).'">'.$rel['postTitle'].'</a><br />';
						}
						echo '
						</p>
						</div>';
					}

				?>
				
				<!--<div id="comments">
				
				<h5>Share Your Thoughts: </h5>-->
				
				<?php
					/*echo '<ul id="comment-container">';
					if($comments != 'empty'){
						echo $seeOlder;
							foreach ($comments as $comment){
								$cmmtDate = ago($comment['commentDate']);
								echo '<li class="comment">
											<div class="commenterProfilePic">
												<img src="'.$website.$comment['profilePicAddr'].'"/>
											</div>
											<div class="commentDetail">
												<a href="'.$website.'account/profile/'.$comment['username'].'" class="commenter">'.$comment['firstName'].' '.$comment['lastName'].'</a><br />
												<p>'.$comment['commentText'].'</p>
												<span>'.$cmmtDate.'</span>
											</div>
											<div class="cleaner"></div>
										</li>';
							}	
					}
					echo '</ul>';
				
					if(isset($_SESSION['userLogin'])){
					echo '
						<div id="comment-box">
							<div class="commenterProfilePic">
								<img src="'.$profilePic.'" />
							</div>
							<div class="commentDetail">
								<a href="#" class="commenter">'.$name.'</a><br />
								<form action="comment.php" method="post">
									<input type="hidden" name="userId" id="userIdhidden" value="'.$userId.'" />
									<input type="hidden" name="postId" id="postIdhidden" value="'.$postId.'" />
									<textarea name="comment" id="commentText"></textarea><br />
									<input type="button" value="Comment" id="comment-button"/>&nbsp;&nbsp;<span class="loading"><span></span></span>
								</form>
							</div>
							<div class="cleaner"></div>
						</div>';
					} else {
					echo '<div class="comment"><strong>You Must Login to post a comment</strong></div>';
					}
					
					echo '</div>';*/
				?>
				
				
			
		</section><!--end of #left-col-->
		
		<?php require("../includes/rightNav.inc.php"); ?>		
	</div><!--end of .wrapper-->
	
</div><!--end of #page -->

<div class="cleaner"></div>

<?php require("../includes/footer.inc.php"); ?>

</div>

</body>
</html>