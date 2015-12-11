<?php
require("includes/conf.inc.php");
require("includes/functions.inc.php");

if(isset($_POST['prNum'])){
	$userId = $_SESSION['userId'];
	$startPr = intval($_POST['prNum']);
	$interval = 1;
	$endPr = $startPr + $interval;
	$seeMorePrObj = new posts();
	$seeMorePr = $seeMorePrObj->getPostReviews($userId,3,3);
	if($seeMorePr == false){
		echo false;
	} else {
		foreach ($seeMorePr as $pr) {
			$dateTime = getdate(strtotime($pr['postDate']));
			echo '
			<div class="postReview" id="'.$pr['postId'].'">
				<h5>'.$pr['postTitle'].'</h5>
				<span>Added at: '.$dateTime['mday'].' '.$dateTime['month'].', '.$dateTime['year'].'</span>
				<span>Category: '.$pr['postTyp'].'</span>
				<span>'.$pr['class'].' > '.$pr['facultyName'].' > '.$pr['subjectName'].' > '.$pr['chapterName'].'</span>
				<div class="review">'.truncate($pr['postText'],500).'</div>
				<a href="'.generate_link($pr['postTitle'],$pr['postId']).'" class="anchor-btn" target="_blank">See More</a>
			</div>';
		}
	}
}

?>